pollanswer = function (t, ao_link) {
   if (t == "-1")
   {
      window.location.href="?lost";
      return true;
   }

   if (t!="1")
   {
      return poll();
   }

   if (!ao_link)
      ao_link = "?";


//      window.location.href = ao_link;
//      return true;


   var r = call(ao_link, true);

   if (r.indexOf("<title>Risk Jack - In Game</title>") == -1)
   {
      window.location.href = ao_link;
      return true;
   }

   if (r.indexOf('id="game_status" value="'+document.getElementById("game_status").value+'"') == -1)
      handle_next_screen(r);

   poll();

   return true;
}


function handle_next_screen (html)
{

   var next_screen = html.split(/<\/?body>/i)[1];

   //    handle differences
   var animation_stack = handle_differences (next_screen);

   //    apply new screen html
   document.body.innerHTML = next_screen;

   //    apply each defined animation (as an overlay visual)
   var i;
   for (i=0; i<animation_stack.length; i++)
      animate_card (animation_stack[i]);

   //    ensure a clean screen
   setTimeout(clean_animation, animation.default.speed+100);
}

function handle_differences (html)
{//return new Array(); /////////
   //THIS FUNCTION IS DEPENDENT ON THE ACTUAL LAYOUT
   var cnt = document.createElement("div");
   cnt.innerHTML = html;

   //Define the stacks
   var animation_stack = new Array();

   var reg_h = new Array();
   var reg_p = new Array();


   var deck = $(document.body).find(".deck .card")[0];
   deck.pos = findPos(deck);
   deck.crd = $(deck).children("img")[0].src;

   var myhand0 = $(document.body).find(".player.hand .cards .card");
   var myhand1 = $(cnt          ).find(".player.hand .cards .card");
   var mh_diff = differences (myhand0, myhand1);

   var played0 = $(document.body).find(".played .cards .card");
   var played1 = $(cnt          ).find(".played .cards .card");
   var pl_diff = differences (played0, played1);

   var opponents0 = $(document.body).find(".opponents .card");
   var opponents1 = $(cnt          ).find(".opponents .card");
   var op_diff = differences (opponents0, opponents1);

   var set0 = $(document.body).find(".set .cards .last-hand.card");
   var set1 = $(cnt          ).find(".set .cards .last-hand.card");
   var st_diff = differences (set0, set1);



   //Handle the negative differences

   var i;
   for (i=0; i<mh_diff[1].length; i++)
   {
      var pos = findPos(mh_diff[1][i]);
      var img = $(mh_diff[1][i]).children("img")[0].src;
      reg_h.push( {pos: pos, card: img} );
   }

   var i;
   for (i=0; i<op_diff[1].length; i++)
   {
      var pos = findPos(op_diff[1][i]);
      var img = $(op_diff[1][i]).children("img")[0].src;
      reg_h.push( {pos: pos, card: img} );
   }

   var i;
   for (i=0; i<pl_diff[1].length; i++)
   {
      var pos = findPos(pl_diff[1][i]);
      var img = $(pl_diff[1][i]).children("img")[0].src;
      reg_p.push( {pos: pos, card: img} );
   }

   var i;
   for (i=0; i<0*st_diff[1].length; i++)
   {
      var ntc = $(".notice")[0];
      var pool;

      if (ntc.innerHTML.indexOf("Your turn") != -1)
         pool = findPos( $(document.body).find(".player.hand .cards .card")[0] );
      else
      {
         var opnts = $(document.body).find(".opponents .player .name");
         pool = null;

         var i;
         for (i=0; i<opnts.length; i++)
         {
            var nm = opnts[i].innerHTML.replace(/^\s+|\s+$/g,'');

            if (ntc.innerHTML.indexOf(nm) == -1)
               continue;

            pool = findPos(opnts[i])
            pool[0] -= -$(opnts[i]).width();

            break;
         }
      }

      var c0pos = findPos(st_diff[1][i]);
      var c0img = $(st_diff[1][i]).children("img")[0].src;
      var c1pos = pool;
      var c1img = null;

      animation_stack.push( [{pos: c0pos, card: c0img}, {pos: c1pos, card: c1img}] );
   }


   //Render the next screen

   document.body.appendChild(cnt);


   //Handle the positive differences

   var i;
   for (i=0; i<mh_diff[0].length; i++)
   {
      var c0pos = deck.pos;
      var c0img = deck.crd;
      var c1pos = findPos(mh_diff[0][i]);
      var c1img = $(mh_diff[0][i]).children("img")[0].src;

      animation_stack.push( [{pos: c0pos, card: c0img}, {pos: c1pos, card: c1img}] );
   }

   var i;
   for (i=0; i<op_diff[0].length; i++)
   {
      var c0pos = deck.pos;
      var c0img = deck.crd;
      var c1pos = findPos(op_diff[0][i]);
      var c1img = $(op_diff[0][i]).children("img")[0].src;

      animation_stack.push( [{pos: c0pos, card: c0img}, {pos: c1pos, card: c1img}] );
   }

   var i;
   for (i=0; i<pl_diff[0].length; i++)
   {
      var c0 = reg_h.shift();
      var c1pos = findPos(pl_diff[0][i]);
      var c1img = $(pl_diff[0][i]).children("img")[0].src;

      animation_stack.push( [c0, {pos: c1pos, card: c1img}] );
   }

   var i;
   for (i=0; i<st_diff[0].length; i++)
   {
      var c0 = (reg_p.length > 0)? reg_p.shift() : reg_h.shift();
      var c1pos = findPos(st_diff[0][i]);
      var c1img = $(st_diff[0][i]).children("img")[0].src;

      animation_stack.push( [c0, {pos: c1pos, card: c1img}] );
   }


   // Return the animation stack
   return animation_stack;
}
   function differences (st0, st1)
   {
      //fill
      var ds = new Array();
      var da = new Array();

      var i;
      dsLoop: for (i=0; i<st0.length; i++)
         if (typeof st0[i].outerHTML != 'undefined')
            ds[ds.length] = st0[i];

      var i;
      daLoop: for (i=0; i<st1.length; i++)
         if (typeof st1[i].outerHTML != 'undefined')
         {
            var j;
            for (j=0; j<ds.length; j++)
               if (ds[j].innerHTML == st1[i].innerHTML)
               {
                  ds.splice(j,1);
                  continue daLoop;
               }

            da[da.length] = st1[i];
         }

      return [da, ds];
   }


animation = new Object();
animation.default = new Object();
animation.default.speed = 500; //ms
animation.objects = new Array();

function animate_card (a)
{
   if (!a[0] || !a[1]) return false;

   //Place the actor card
   var ac = document.createElement("img");
   animation.objects.push(ac);
   ac.src = a[1].card;
   document.body.appendChild(ac);
   ac.style.position = "absolute";
   ac.style.left = a[0].pos[0];
   ac.style.top  = a[0].pos[1];
   ac.style.zIndex = 2;

   //Remove the actual card
   ac.real = document.elementFromPoint(a[1].pos[0], a[1].pos[1]);
   if (ac.real.parentNode.className.indexOf("card") != -1)
      ac.real = ac.real.parentNode;
   ac.real.style.visibility = "hidden";

   //Start the animation
   $(ac).animate({left: a[1].pos[0], top: a[1].pos[1]}, animation.default.speed, clean_animation);

   return true;
}
   function clean_animation () {
      if (this.real)
      {
         //Return the actual card
         this.real.style.visibility = "";

         //Remove the actor
         this.parentNode.removeChild(this);

         animation.objects.splice(animation.objects.indexOf(this),1);
         return true;
      }


      //Useless cause when it's needed it is not reached
      var i;
      for (i=0; i<animation.objects.length; i++)
      {
         animation.objects[i].parentNode.removeChild(animation.objects[i]);
      }
   }

function animate (c0, c1, properties)
{
   //c0 , c1  /Card 0 , Card 1/
   //c0 = {card: "back", x: 1000, y: 50}    //Example
   //c1 = {card: "1s",   x: 400,  y: 300}   //Example

   // if c0 == null && c1 == null   ->  return true;

   // create and place c0 object

   // if c0.card == c1.card  ->  just slide
   // if c0 == null          ->  fade in
   // if c1 == null          ->  fade out
   // if c0.card != c1.card  ->  flip slide
}

function slide (elem, to, properties)
{
   // from = findPos(elem);
   // to = {x: 400, y: 300};

   var from = findPos(elem);
   var x0 = from[0];
   var y0 = from[1];

   if ( (typeof to.x != 'number' || typeof to.y != 'number') && (typeof to[0] != 'number' || typeof to[1] != 'number') )
      return false;

   var x1 = (typeof to.x == 'number'? to.x : to[0]);
   var y1 = (typeof to.y == 'number'? to.y : to[1]);

   if (properties)
   {
      var duration = (typeof properties.duration != 'number'? (typeof properites.speed != 'number'? animation.default.speed    : properties.speed) : properties.duration);
      var accuracy = (typeof properties.accuracy != 'number'? (typeof properites.step  != 'number'? animation.default.accuracy : properties.step)  : properties.accuracy);
   }
   else
   {
      var duration = animation.default.speed;
      var accuracy = animation.default.accuracy;
   }


   var steps = Math.max( (Math.abs(x0-x1) / accuracy) , (Math.abs(y0-y1) / accuracy) );
   var sx = (x1-x0)/steps;
   var sy = (y1-y0)/steps;
   var st = duration/steps;

   elem.animation = new Object();
   elem.animation.index = 0;
   elem.animation.steps = steps;
   elem.animation.act = null;
   elem.animation.timeout = null;

   act_slide (elem, [x0, y0], [x1, y1], [sx, sy], st);
}
   function act_slide (e, f, t, s, d)
   {
      // f(element, from[2], to[2], steps[2], delay)

      var i = e.animation.index++;

      if (i == e.animation.steps)
      {
         var x = t[0];
         var y = t[1];
      }
      else
      {
         var x = f[0] + i*s[0];
         var y = f[1] + i*s[1];
      }

      e.style.position = "absolute";
      e.style.left = x + "px";
      e.style.top  = y + "px";

      if (typeof e.animation.act != "function")
         e.animation.act = function () { act_slide(e, f, t, s, d); };

      if (i < e.animation.steps)
         e.animation.timeout = setTimeout(e.animation.act, d);
   }

function flip_slide (elem, to, elem2, properties)
{
   // from = findPos(elem);
   // to = {x: 400, y: 300};

   var from = findPos(elem);
   var x0 = from[0];
   var y0 = from[1];

   if ( (typeof to.x != 'number' || typeof to.y != 'number') && (typeof to[0] != 'number' || typeof to[1] != 'number') )
      return false;

   var x1 = (typeof to.x == 'number'? to.x : to[0]);
   var y1 = (typeof to.y == 'number'? to.y : to[1]);

   if (properties)
   {
      var duration = (typeof properties.duration != 'number'? (typeof properites.speed != 'number'? animation.default.speed    : properties.speed) : properties.duration);
      var accuracy = (typeof properties.accuracy != 'number'? (typeof properites.step  != 'number'? animation.default.accuracy : properties.step)  : properties.accuracy);
   }
   else
   {
      var duration = animation.default.speed;
      var accuracy = animation.default.accuracy;
   }


   var steps = Math.max( (Math.abs(x0-x1) / accuracy) , (Math.abs(y0-y1) / accuracy) );
   var sx = (x1-x0)/steps;
   var sy = (y1-y0)/steps;
   var sp = 1/steps;
   var st = duration/steps;

   elem.animation = new Object();
   elem.animation.index = 0;
   elem.animation.steps = steps;
   elem.animation.act = null;
   elem.animation.timeout = null;

   act_flip_slide (elem, elem2, [x0, y0], [x1, y1], [sx, sy, sp], st);
}
   function act_flip_slide (e, b, f, t, s, d)
   {
      // f(element, backside, from[2], to[2], steps[2], delay)

      var i = e.animation.index++;

      if (i == e.animation.steps)
      {
         var x = t[0];
         var y = t[1];
         var p1 = 1;
         var p2 = 0;
      }
      else
      {
         var x = f[0] + i*s[0];
         var y = f[1] + i*s[1];
         var p1 = 1 - i*s[2];
         var p2 = i*s[2];
      }

      e.style.position = "absolute";
      e.style.left = x + "px";
      e.style.top  = y + "px";
      e.style.transform = "scaleX("+p1+")";

      b.style.position = "absolute";
      b.style.left = x + "px";
      b.style.top  = y + "px";
      e.style.transform = "scaleX("+p2+")";

      if (typeof e.animation.act != "function")
         e.animation.act = function () { act_flip_slide(e, b, f, t, s, d); };

      if (i < e.animation.steps)
         e.animation.timeout = setTimeout(e.animation.act, d);
   }


function fade_in (elem, properties)
{
}

function fade_out (elem, properties)
{
}

   function findPos(obj) {
      var curleft = curtop = 0;
      if (!obj.offsetParent) return false;

      do {
         curleft += obj.offsetLeft;
         curtop += obj.offsetTop;
      } while (obj = obj.offsetParent);

      return [curleft,curtop];
   }




var anchors = document.getElementsByTagName("a");

var i;
for (i=0; i<anchors.length; i++)
{
   var hrf = anchors[i].getAttribute('href');
   var _oncl = anchors[i].getAttribute('onclick');
   anchors[i].onclick = function () {
      pollanswer("1", hrf);
      eval(_oncl);
   }
   anchors[i].setAttribute('href', "");
}

//if (!play())
//{
   play = function (card) {
      pollanswer("1", "?play="+card);
   }
//}


<?php exit; ?>

<?php
if (isset($_REQUEST['preferance']))
{
   if (isset($_REQUEST['sorting']))
   {
      setcookie("pref_sorting", $_REQUEST['sorting'], time()+2592000);
   }
   exit;
}
?>
<html>
<head>
   <title>Risk Jack - In Game</title>
   <link rel="stylesheet" type="text/css" href="index.php?css&ingame" />
   <style type="text/css">
   .player.hand .footer {
      margin-top: -0.5em;
      transition: margin-top, 1s;
      padding-top: 0.5em;
   }
   .player.hand .footer:hover {
      margin-top: -1.5em;
   }
   .player.hand .footer .suits {
      display: inline-block;
      padding: 0.25em 1.5em 0em;
      background-color: #B8D7F2;
      border-top-left-radius: 1em;
      border-top-right-radius: 1em;
      box-shadow: 0em 0em 0.25em 0.25em #B8D7F2;
   }
   .player.hand .footer .suit {
      display: inline-block;
      background-color: #6496C8;
      padding: 0em 0.25em;
      margin: 0em 0.5em;
   }
   .player.hand .footer .suit:before {
      content: '';
      display: inline-block;
      float: left;
      border-top: 0.5em solid #6496C8;
      border-bottom: 0.5em solid #6496C8;
      border-left: 1em solid transparent;
      margin: 0em 1.25em -1em -1.25em;
   }
   .player.hand .footer .suit:after {
      content: '';
      display: inline-block;
      float: right;
      border-top: 0.5em solid transparent;
      border-bottom: 0.5em solid transparent;
      border-left: 1em solid #6496C8;
      margin: -1em -1.25em 0em 1.25em;
   }
   .player.hand .footer .suit .name {
      display: none;
   }
   .player.hand .footer .suit .icon {
      display: block;
      width: 1em;
      height: 1em;
   }
   .player.hand .footer .suit .icon img {
      width: 1em;
      height: 1em;
   }
   </style>
</head>
<body>

<div class="deck">
   <div class="cards">
      <div class="card">
         <img src="img/back.png" alt="Back of Card" title="Back of Card" />
         <div class="name">Back of Card</div>
      </div>
   </div>

   <div class="description">
      <span class="number">42</span>
      <div class="clarification">in deck</div>
   </div>
</div>
<div class="notice">
   <div class="turn">
   gabarieko's turn
   </div>
</div>
<div class="played hand">
   <div class="header">Played cards:</div>

   <div class="cards">


   </div>
</div>
<div class="set hand">
   <div class="cards">


   </div>

   <div class="description">
      <span class="number">0</span>
      <div class="clarification">set hands</div>
   </div>

</div>
<div class="player hand">
   <div class="header">Cards in hand:</div>

   <div class="cards">

      <div class="card" onclick="play('3d');">
         <img src="img/3d.png" alt="Three of Diamonds" title="Three of Diamonds" />
         <div class="name">Three of Diamonds</div>
      </div>
      <div class="card" onclick="play('6h');">
         <img src="img/6h.png" alt="Six of Hearts" title="Six of Hearts" />
         <div class="name">Six of Hearts</div>
      </div>
      <div class="card" onclick="play('7h');">
         <img src="img/7h.png" alt="Seven of Hearts" title="Seven of Hearts" />
         <div class="name">Seven of Hearts</div>
      </div>
      <div class="card" onclick="play('qh');">
         <img src="img/qh.png" alt="Queen of Hearts" title="Queen of Hearts" />
         <div class="name">Queen of Hearts</div>
      </div>
      <div class="card" onclick="play('0h');">
         <img src="img/0h.png" alt="Ten of Hearts" title="Ten of Hearts" />
         <div class="name">Ten of Hearts</div>
      </div>

   </div>

   <div class="footer">
      <div class="suits">
         <div class="suit" name="movable">
            <span class="name">Clubs</span>
            <span class="icon"> <img src="img/clubs.png" /> </span>
         </div>
         <div class="suit" name="movable">
            <span class="name">Diamonds</span>
            <span class="icon"> <img src="img/diamonds.png" /> </span>
         </div>
         <div class="suit" name="movable">
            <span class="name">Hearts</span>
            <span class="icon"> <img src="img/hearts.png" /> </span>
         </div>
         <div class="suit" name="movable">
            <span class="name">Spades</span>
            <span class="icon"> <img src="img/spades.png" /> </span>
         </div>
      </div>
   </div>
</div>
<div class="opponents">
   <div class="player">
      <div class="hand">

         <div class="card">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
         <div class="card">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
         <div class="card">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
         <div class="card">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
         <div class="card">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

      </div>
      <div class="name">
         gabarieko
      </div>
   </div>
</div>

</body>

<script type="text/javascript">
var ms = document.getElementsByName("movable");
movables = new Array();
 change = 0;

function findPos(obj) {
   var curleft = curtop = 0;
   if (obj.offsetParent) {
      do {
         curleft += obj.offsetLeft;
         curtop += obj.offsetTop;
      } while (obj = obj.offsetParent);

      return [curleft,curtop];
   }
   return false;
}

var i;
for (i=0; i < ms.length; i++)
{
   ms[i].onmousedown = dragStart;
   document.onmouseup   = dragEnd;
   ms[i].parentNode.onmousemove = dragMove;
   ms[i].parentNode.shouldMove = false;
   ms[i].parentNode.change = 0;
   movables[i] = findPos(ms[i])[0];
}

currently_dragged = null;

function dragStart (event) {
   if (event.preventDefault)
      event.preventDefault();

   currently_dragged = this;

   currently_dragged.shouldMove = true;
   currently_dragged.clickedX = event.clientX;

   if (typeof currently_dragged.index == "undefined")
   {
      var i = 0;
      while (typeof movables[i] != "undefined")
         if (currently_dragged.clickedX >= movables[i])
            i++;
         else
            break;

      currently_dragged.index = i>0 ? i-1 : 0;
   }

   currently_dragged.style.position = "relative";
   currently_dragged.style.zIndex = "1";
   currently_dragged.style.boxShadow = "-0.25em 0.25em 0.25em 0px gray";
}
function dragEnd (suppressed) {
   if (!currently_dragged) return true;
   if (typeof suppressed != 'boolean')
      suppressed = false;

   currently_dragged.shouldMove = false;
   currently_dragged.clickedX = null;

   currently_dragged.style.position = "relative";
   currently_dragged.style.zIndex = "0";
   currently_dragged.style.top = "0em";
   currently_dragged.style.left = "0em";
   currently_dragged.style.boxShadow = "0em 0em 0em 0px gray";

   if (!suppressed && currently_dragged.change != 0)
   {
      //make update call
      var ms = document.getElementsByName("movable");
      var sortprefstr = "";

      var i;
      for (i=0; i<ms.length; i++)
      {
         var j;
         for (j=0; j<ms[i].childNodes.length; j++)
         {
            var elem = ms[i].childNodes[j];
            if (!elem.className || elem.className != "name")
               continue;

            var suitName = elem.innerHTML.toLowerCase();
            if (suitName.indexOf("club") != -1)
               sortprefstr += "1";
            if (suitName.indexOf("diamond") != -1)
               sortprefstr += "2";
            if (suitName.indexOf("heart") != -1)
               sortprefstr += "3";
            if (suitName.indexOf("spade") != -1)
               sortprefstr += "4";
         }
      }

      alert("?preferance&sorting="+sortprefstr);
   }
   currently_dragged.change = 0;

   currently_dragged = null;
   return true;
}

function dragMove (event) {
   if (!currently_dragged)
      return true;
   if (!currently_dragged.shouldMove)
      return false;

   var i = 0;
   while (typeof movables[i] != "undefined")
      if (event.clientX >= movables[i])
         i++;
      else
         break;
   if (i>0) i--;

   var ind = currently_dragged.index;
   var chg;// = currently_dragged.change;

   if (i != ind)
   {
      var correction = currently_dragged.clickedX - movables[currently_dragged.index];
      if (i < ind) correction -= 2.5*16; //2em';

      currently_dragged.change -= ind-i;
      chg = currently_dragged.change;
      currently_dragged.change = 0;

      //dragEnd(1)
      dragEnd(true);

      //change nameplates
      var ms = document.getElementsByName("movable");

      var tmp = ms[i].innerHTML;
      ms[i].innerHTML = ms[ind].innerHTML;
      ms[ind].innerHTML = tmp;


      dragStart.call(ms[i], {clientX: event.clientX-(-correction)});

      currently_dragged.change = chg;
   }

   currently_dragged.style.left = (event.clientX - currently_dragged.clickedX)+"px";
}
</script>

</html>

<?php exit; ?>

<?php
if (isset($_REQUEST['poll']))
{
   sleep(2);
   echo "Answered";
   exit;
}
?>
<html>
<head>
   <title> xmlhttp test </title>
   <script type="text/javascript">

      xmlhttp = new Array();

      function call(url, callback, sync){
         async = (typeof callback == "boolean")? !callback : (sync!=null)? !sync : true;

         if(window.XMLHttpRequest)
            var xh = new XMLHttpRequest();
         else
         if(window.ActiveXObject)
            var xh = new ActiveXObject("Microsoft.XMLHTTP");
         else
            return false;


         if(typeof callback != "boolean" && callback!=null)
            xh.onreadystatechange = function(){
               if (this.readyState==4 && this.status==200)
                  callback(this.responseText);
               xmlhttp.splice(xmlhttp.indexOf(this), 1);
            }

         xh.open("GET", url, async);
         xh.send(null);

         xmlhttp.push(xh);
         return async? xh : xh.responseText;
      }

      function poll (pollfor, state) {
         if (!pollfor) return;

         call("?poll", pollanswer);
      }

      function pollanswer (t){
         alert(t);
      }
   </script>
</head>
<body>
</body>

<script type="text/javascript">
   pollanswer = function (t) {
      alert("changed");
   }
</script>

<script type="text/javascript">
   poll("game:3");
</script>

</html>

<?php exit; ?>

<html>
<head>
   <title>Risk Jack - In Game</title>
   <style type="text/css">
   body {
      background-color: #8CAB35;
   }

   .cards {
      min-height: 6em;
   }

   .card > .name {
      display: none;
   }

   .cards .card,
   .hand .card {
      display: inline-block;
   }

   .set .cards .card,
   .played .cards .card,
   .opponents .player .card {
      width: 1.5em;
      overflow: visible;
   }

   .description {
      padding: 0em 0.25em;
      background-color: rgba(170, 205, 65, 0.85);
      box-shadow: 0px 0px 5px 5px rgba(170, 205, 65, 0.85);
      position: relative; /* z-index: top */
      border-top-right-radius: 1.5em;
   }

   .action {
      display: block;
      width: 7.5em;
      border-radius: 1em;
      text-align: center;
      cursor: pointer
      color: #36516C;
      text-decoration: none;
      font-weight: bold;
      background-color: rgba(100, 150, 200, 0.5);
      box-shadow: 0em 0em 0.5em 0.5em rgba(100, 150, 200, 0.5);
   }
   .action:hover {
      color: black;
      background-color: rgba(100, 150, 200, 1);
      box-shadow: 0em 0em 0.5em 0.5em rgba(100, 150, 200, 1);
   }

   a {
      color: inherit;
      text-decoration: inherit;
   }


   .deck {
      margin: 2em;
   }

   .deck .description {
      display: inline-block;
      margin: -2em 0em 0em 2em;
      text-align: right;
      border-bottom-left-radius: 1.5em;
   }
   .deck .description > .number {
      font-size: 1.5em;
      font-weight: bold;
   }
   .deck .description > .number:after {
      content: ' cards';
      font-size: 0.65em;
      font-weight: normal;
      margin-left: 0.25em;
   }

   .turn.notice {
      display: block;
      width: 30%;
      min-width: 15em;
      text-align: center;
      margin: 1em;
      border-radius: 1em;
      position: absolute;
      top: 2em;
      left: 35%;
      background-color: rgba(170, 205, 65, 1);
      box-shadow: 0px 0px 5px 5px rgba(170, 205, 65, 1);
      z-index: 2;
   }

   .played.hand {
      display: block;
      width: 30%;
      text-align: center;
      margin: 1em;
      border-radius: 1em;
      background-color: rgba(170, 205, 65, 1);
      box-shadow: 0px 0px 5px 5px rgba(170, 205, 65, 1);
      position: absolute;
      top: 25%;
      left: 35%;
   }
   .played.hand .cards .card {
      margin-left: -1.5em;
      margin-right: 1.5em;
   }

   .set.hand {
      display: inline-block;
      text-align: right;
      margin: 1em;
      position: absolute;
      top: 25%;
      left: 10%;
      margin-top: 12em;
   }
   .set.hand .last-hand.card {
      margin-left: -4em;
      margin-right: 4em;
   }
   .set.hand .description {
      display: inline-block;
      float: right;
      margin: -2.5em -5em 0em 0em;
      text-align: left;
   }
   .set.hand .description .number {
      font-size: 1.5em;
      font-weight: bold;
   }

   .set.hand .action {
      margin: -5.5em -85% 5.5em 85%;
      position: relative;
      left: 5em;
   }

   .player.hand {
      position: fixed;
      bottom: 0em;
      left: 0em;
      display: block;
      width: 100%;
      height: 7.5em;
      text-align: center;
      padding: 0em 1em 0.5em;
      background-color: rgba(100, 150, 200, 0.5);
      box-shadow: 0em 0em 1em 1em rgba(100, 150, 200, 0.5);
      z-index: 2;
   }
   .player.hand.unavailable{
      background-color: rgba(255, 90, 90, 0.5);
      box-shadow: 0em 0em 1em 1em rgba(255, 90, 90, 0.5);
   }
   .player.hand.unavailable:hover{
      background-color: rgba(255, 50, 50, 1);
      box-shadow: 0em 0em 1em 1em rgba(255, 50, 50, 1);
   }
   .player.hand .action {
      margin: -10em auto 10em;
   }

   .opponents {
      position: absolute;
      top: 0em;
      right: 0em;
      width: 30%;
      text-align: right;
   }
   .opponents {
      height: 100%;
      overflow: auto;
   }
   .opponents > *:last-child {
      padding-bottom: 10em;
   }
   .opponents .player {
      margin: 2em 4em 2em -4em;
   }
   </style>
</head>
<body>

<div class="deck">
   <div class="cards">
      <div class="card" onclick="draw();">
         <img src="img/back.png" alt="Back of Card" title="Back of Card" />
         <div class="name">Back of Card</div>
      </div>
   </div>

   <div class="description">
      <span class="number">42</span>
      <div class="clarification">in deck</div>
   </div>
</div>

<div class="turn notice">
   Your turn
</div>

<div class="played hand">
   <div class="header">Played cards:</div>

   <div class="cards">
      <div class="card" onclick="play('9c');">
         <img src="img/9c.png" alt="Nine of Clubs" title="Nine of Clubs" />
         <div class="name">Nine of Clubs</div>
      </div>

      <div class="card" onclick="play('9c');">
         <img src="img/9c.png" alt="Nine of Clubs" title="Nine of Clubs" />
         <div class="name">Nine of Clubs</div>
      </div>
   </div>
</div>

<div class="set hand">
   <div class="cards">
      <div class="last-hand card" onclick="play('9c');">
         <img src="img/9c.png" alt="Nine of Clubs" title="Nine of Clubs" />
         <div class="name">Nine of Clubs</div>
      </div>

      <div class="last-hand card" onclick="play('9c');">
         <img src="img/9c.png" alt="Nine of Clubs" title="Nine of Clubs" />
         <div class="name">Nine of Clubs</div>
      </div>

      <div class="card" onclick="draw();">
         <img src="img/back.png" alt="Back of Card" title="Back of Card" />
         <div class="name">Back of Card</div>
      </div>

      <div class="card" onclick="draw();">
         <img src="img/back.png" alt="Back of Card" title="Back of Card" />
         <div class="name">Back of Card</div>
      </div>

      <div class="card" onclick="draw();">
         <img src="img/back.png" alt="Back of Card" title="Back of Card" />
         <div class="name">Back of Card</div>
      </div>

      <div class="card" onclick="draw();">
         <img src="img/back.png" alt="Back of Card" title="Back of Card" />
         <div class="name">Back of Card</div>
      </div>

      <div class="card" onclick="draw();">
         <img src="img/back.png" alt="Back of Card" title="Back of Card" />
         <div class="name">Back of Card</div>
      </div>

      <div class="card" onclick="draw();">
         <img src="img/back.png" alt="Back of Card" title="Back of Card" />
         <div class="name">Back of Card</div>
      </div>

   </div>

   <div class="description">
      <span class="number">6</span>
      <div class="clarification">set hands</div>
   </div>

   <div class="action">
      <a href="#take">Take</a>
   </div>
</div>

<div class="player hand">
   <div class="header">Cards in hand:</div>

   <div class="cards">
      <div class="card" onclick="play('9c');">
         <img src="img/9c.png" alt="Nine of Clubs" title="Nine of Clubs" />
         <div class="name">Nine of Clubs</div>
      </div>

      <div class="card" onclick="play('9c');">
         <img src="img/9c.png" alt="Nine of Clubs" title="Nine of Clubs" />
         <div class="name">Nine of Clubs</div>
      </div>

      <div class="card" onclick="play('9c');">
         <img src="img/9c.png" alt="Nine of Clubs" title="Nine of Clubs" />
         <div class="name">Nine of Clubs</div>
      </div>

      <div class="card" onclick="play('9c');">
         <img src="img/9c.png" alt="Nine of Clubs" title="Nine of Clubs" />
         <div class="name">Nine of Clubs</div>
      </div>
   </div>

   <div class="action">
      <a href="#draw">Draw</a>
   </div>
</div>

<div class="opponents">
   <div class="player">
      <div class="hand">
         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
      </div>
      <div class="name">
         Player 2
      </div>
   </div>
   <div class="player">
      <div class="hand">
         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
      </div>
      <div class="name">
         Player 3
      </div>
   </div>
   <div class="player">
      <div class="hand">
         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
      </div>
      <div class="name">
         Player 4
      </div>
   </div>
   <div class="player">
      <div class="hand">
         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
      </div>
      <div class="name">
         Player 5
      </div>
   </div>

   <div class="player">
      <div class="hand">
         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>

         <div class="card" onclick="draw();">
            <img src="img/back.png" alt="Back of Card" title="Back of Card" />
            <div class="name">Back of Card</div>
         </div>
      </div>
      <div class="name">
         Player 6
      </div>
   </div>
</div>

</body>
</html>

<?php exit; ?>

<html>
<head>
   <title>Risk Jack - Pre-Game</title>
   <script type="text/javascript" src="?js&call&poll&clean"></script>
   <link rel="stylesheet" type="text/css" href="index.php?css&pregame" />
</head>
<body>

<div class="pre-game main">
   <div class="name">gabarieko's game</div>

   <div class="ruleset">
      <div class="header">Rules</div>

      <select class="preset" onchange="selectPreset(this.value);">
         <option value="exhausting2">Exhausting 1v1</option>
         <option value="curious2">Curious 1v1</option>
         <option value="casual2">Casual 1v1</option>
         <option value="custom" style="display: none;" selected>Custom</option>
      </select>
      <script type="text/javascript">
         presets = new Object();
         presets["exhausting2"] = {playerCount: 2, startingHand: 5, forcedAnswer: 1, forcedRaise: 0, turnDraw: 0, takeDraw: 1, emptyDraw: 2};
         presets["curious2"] = {playerCount: 2, startingHand: 2, forcedAnswer: 1, forcedRaise: 0, turnDraw: 0, takeDraw: 0, emptyDraw: 2};
         presets["casual2"] = {playerCount: 2, startingHand: 5, forcedAnswer: 0, forcedRaise: 0, turnDraw: 1, takeDraw: 0, emptyDraw: 0};

         function selectPreset (prst) {
            var p = presets[prst];
            window.location.href="?update"+("&playerCount="+p.playerCount)+("&startingHand="+p.startingHand)+("&forcedAnswer="+p.forcedAnswer)+("&forcedRaise="+p.forcedRaise)+("&turnDraw="+p.turnDraw)+("&takeDraw="+p.takeDraw)+("&emptyDraw="+p.emptyDraw);
         }
      </script>

      <div class="toggler" state="0" onclick="this.setAttribute('state', (this.getAttribute('state')==1? '0' : '1'));"></div>
      <div class="rules">
         <div class="rule" id="player-count">
            <span class="title">Player count</span>
            <span class="value"> <b>2</b> players</span>
         </div>
         <div class="rule" id="starting-hand">
            <span class="title">Starting hand</span>
            <span class="value"> <b>5</b> cards</span>
         </div>
         <div class="rule" id="forced-answer">
            <span class="title">Must Answer</span>
            <span class="value">Yes</span>
         </div>
         <div class="rule" id="forced-raise">
            <span class="title">Must Raise</span>
            <span class="value">Yes</span>
         </div>
         <div class="rule" id="turn-draw">
            <span class="title">Turn Draw</span>
            <span class="value">No</span>
         </div>
         <div class="rule" id="take-draw">
            <span class="title">Take Draw</span>
            <span class="value">Yes</span>
         </div>
         <div class="rule" id="empty-draw">
            <span class="title">Empty Draw</span>
            <span class="value"> <b>2</b> cards</span>
         </div>
      </div>
   </div>

   <div class="players">
      <div class="header">Players</div>
      <span class="joined">2</span>
       /
      <span class="maximum">2</span>

      <div class="slots">
         <div class="slot">
            <span class="position" name="movable">1</span>
            <span class="player-name">gabarieko</span>
         </div>
         <div class="slot">
            <span class="position" name="movable">2</span>
            <span class="player-name">zemuru</span>
         </div>
         <div class="slot">
            <span class="position" name="movable">3</span>
            <span class="player-name">abija</span>
         </div>
         <div class="slot">
            <span class="position" name="movable">4</span>
            <span class="player-name">stayo</span>
         </div>
         <div class="slot">
            <span class="position" name="movable">5</span>
            <span class="player-name">magushi</span>
         </div>
         <div class="slot">
            <span class="position" name="movable">6</span>
            <span class="player-name">meco pug</span>
         </div>
      </div>

      <script type="text/javascript">
      var ms = document.getElementsByName("movable");
      movables = new Array();
       change = 0;

      function findPos(obj) {
         var curleft = curtop = 0;
         if (obj.offsetParent) {
            do {
               curleft += obj.offsetLeft;
               curtop += obj.offsetTop;
            } while (obj = obj.offsetParent);

            return [curleft,curtop];
         }
         return false;
      }

      var i;
      for (i=0; i < ms.length; i++)
      {
         ms[i].onmousedown = dragStart;
         document.onmouseup   = dragEnd;
         ms[i].parentNode.onmousemove = dragMove;
         ms[i].parentNode.shouldMove = false;
         ms[i].parentNode.change = 0;
         movables[i] = findPos(ms[i])[1];
      }

      currently_dragged = null;

      function dragStart (event) {
         if (event.preventDefault)
            event.preventDefault();

         currently_dragged = this.parentNode;

         currently_dragged.shouldMove = true;
         currently_dragged.clickedY = event.clientY;

         if (typeof currently_dragged.index == "undefined")
         {
            var i = 0;
            while (typeof movables[i] != "undefined")
               if (currently_dragged.clickedY >= movables[i])
                  i++;
               else
                  break;

            currently_dragged.index = i>0 ? i-1 : 0;
         }

         currently_dragged.style.position = "relative";
         currently_dragged.style.zIndex = "1";
         currently_dragged.style.left = "0.5em";
         currently_dragged.style.boxShadow = "-0.25em 0.25em 0.25em 0px gray";
      }
      function dragEnd (suppressed) {
         if (!currently_dragged) return true;
         if (typeof suppressed != 'boolean')
            suppressed = false;

         currently_dragged.shouldMove = false;
         currently_dragged.clickedY = null;

         currently_dragged.style.position = "relative";
         currently_dragged.style.zIndex = "0";
         currently_dragged.style.top = "0em";
         currently_dragged.style.left = "0em";
         currently_dragged.style.boxShadow = "0em 0em 0em 0px gray";

         if (!suppressed && currently_dragged.change != 0)
         {
            //make update call
            alert('?update&pid='+(currently_dragged.index - currently_dragged.change)+'&chg='+(currently_dragged.change));
         }
         currently_dragged.change = 0;

         currently_dragged = null;
         return true;
      }

      function dragMove (event) {
         if (!currently_dragged)
            return true;
         if (!currently_dragged.shouldMove)
            return false;

         var i = 0;
         while (typeof movables[i] != "undefined")
            if (event.clientY >= movables[i])
               i++;
            else
               break;
         if (i>0) i--;

         var ind = currently_dragged.index;
         var chg;// = currently_dragged.change;

         if (i != ind)
         {
            var correction = currently_dragged.clickedY - movables[currently_dragged.index];
            if (i < ind) correction -= 32; //2em

            currently_dragged.change -= ind-i;
            chg = currently_dragged.change;
            currently_dragged.change = 0;

            //dragEnd(1)
            dragEnd(true);

            //change nameplates
            var ms = document.getElementsByName("movable");

            var l;
            for (l=0; l < ms[i].parentNode.childNodes.length; l++)
            {
               var elem = ms[i].parentNode.childNodes[l];
               if (elem.className && elem.className.indexOf("player-name") == -1)
                  continue;

               var tmp = elem.innerHTML;
               elem.innerHTML = ms[ind].parentNode.childNodes[l].innerHTML;
               ms[ind].parentNode.childNodes[l].innerHTML = tmp;
            }


            //dragStart.call(elem, {clientY:}
            dragStart.call(ms[i], {clientY: event.clientY-(-correction)});

            currently_dragged.change = chg;
         }

         currently_dragged.style.top = (event.clientY - currently_dragged.clickedY)+"px";
      }
      </script>

   </div>
<div class="actions">
   <button onclick="window.location.href='?startgame';">Start Game</button>
   <button onclick="window.location.href='?leavegame';">Leave Game</button>
</div>
</div>

</body>

<script type="text/javascript">
   poll("game:1");
</script>

</html>