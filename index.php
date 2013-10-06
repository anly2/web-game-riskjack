<?php
session_start();
include_once "mysql.php";
mysql_("");

variables:
{
   define('status_margin', 1000, true);
   define('em', 16, true); //px
   define('cardsPerDeal', 3, true);
   define('observe_speed', 1000, true); //ms
}


login_check:
{
      $stayin = isset($_COOKIE['stayin'])? mysql_real_escape_string($_COOKIE['stayin']) : "";
   if (mysql_("SELECT Username FROM rsk_users WHERE SID='".session_id()."' OR SID='$stayin'", true) > 0)
      $_SESSION['user'] = mysql_("SELECT Username FROM rsk_users WHERE SID='".session_id()."' OR SID='$stayin'");
   else
      unset($_SESSION['user']);
}


css:
{
   if (isset($_REQUEST['css']))
   {
      echo '
body {
   font-size: '.(em).'px;
   font-family: Times New Roman, Helvetica, Verdana, Arial;
   margin: 0;
   padding: 0;
}
';

      if (isset($_REQUEST['login']) || count($_REQUEST)==1)
      {
         echo <<<EOT
.login.main {
   margin: 20% auto;
   width: 15em;
   height: 5em;
}
.login.main {
   text-align: center;
}

.login.main .stage {
   background-color: rgba(100, 150, 200, 1);
   border-radius: 1em;
   padding: 1em;
}

.login.main .remember {
   float: right;
   margin: 0.25em 0 -0.25em -2em;
}

.login.main input {
   padding: 0.5em;
   border-radius: 1em;
   text-align: center;
}

.login.main input[type="submit"] {
   width: 8em;
   background-color: #4D7399;
   margin-bottom: -2em;
}

.login.main .stage.active {
   margin-top: -1.6em;
}

.login.main .stage:not(.active) {
   display: none;
}
.login.main .stage#s1 {
   display: block;
}

.login.main .stage .header {
   display: block;
   width: 80%;
   margin: 0.5em auto;
   font-weight: bold;
   border-bottom: 1px solid #36516C;
}

.login.main .stage label {
   display: inline-block;
   margin: 0.5em auto;
}

.login.main .stage .error {
   font-weight: bold;
   color: red;
   background-color: rgba(255, 0, 0, 0.5);
   border-radius: 1em;
   padding: 0.5em 0em;
}

.login.main input.wrong {
   background-color: #FF7D78;
}
EOT;
      }

      if (isset($_REQUEST['lobby']) || count($_REQUEST)==1)
      {
         echo <<<EOT
.lobby.main {
   width: 80%;
   margin: 5em auto 0em;
   text-align: center;
}

.lobby button {
   font-weight: bold;
   padding: 0.5em 1em;
   border-radius: 1em;
   text-align: center;
   background-color: #4D7399;
   cursor: pointer;
}

.lobby .games {
   padding: 1em;
   margin: 1em auto;
}

.lobby .games .header {
   font-size: 1.2em;
   font-weight: bold;
   width: 10em;
   margin: 0em auto;
   border-bottom: 1px solid #36516C;
}
.lobby .games .filter {
   float: right;
   margin: -1.5em 10% 0.5em 0%;
}
.lobby .games .filter:after {
   display: inline-block;
   content: "";
   width: 1.25em;
   height: 1.25em;
   background-image: url('img/loop.gif');
   background-size: 1.25em;
   background-repeat: no-repeat;
   margin: 0.3em 0em -0.3em -1.3em;
}

.lobby .games .when-empty {
   font-style: italic;
   text-align: center;
   clear: both;
   padding: 0.5em 0em;
   height: 1.25em;
   position: relative; /* for the z-index to work */
   z-index: -1;
}
.lobby .games .when-empty ~ .game {
   position: relative;
   top: -3em;
}

.lobby .games .game {
   background-color: #B8D7F2;
   border-radius: 1em;
   padding: 0.5em 2em;
   width: 80%;
   margin: 0.5em auto 0em;
   overflow: auto;
   cursor: pointer;
}
.lobby .games .game:hover {
   background-color: #73AFE6;
}
.lobby .games .game.hidden {
   display: none;
}

.lobby .games .game > * {
   display: inline-block;
   text-align: left;
}
.lobby .games .game > .name {
   float: left;
   width: 15em;
   text-overflow: ellipsis;
   margin-right: 2em;
}
.lobby .games .game > .name:before {
   display: inline-block;
   content: "Name:";
   font-style: italic;
   margin-right: 1em;
}
.lobby .games .game > .players {
   float: left;
   width: 8em;
   text-overflow: ellipsis;
   margin-right: 2em;
}
.lobby .games .game > .players:before {
   display: inline-block;
   content: "Players:";
   font-style: italic;
   margin-right: 1em;
}
.lobby .games .game > .rules {
   float: left;
   width: 15em;
   text-overflow: ellipsis;
}
.lobby .games .game > .rules:before {
   display: inline-block;
   content: "Rules:";
   font-style: italic;
   margin-right: 1em;
}
EOT;
      }

      if (isset($_REQUEST['pregame']) || count($_REQUEST)==1)
      {
         echo <<<EOT
.pre-game.main {
   margin: 5em 25%;
   text-align: center;
}

.pre-game.main > .name {
   font-size: 1.05em;
   font-weight: bold;
}
.pre-game.main > .name {
   display: block;
   width: 30em;
   overflow: hidden;
   margin: 0.5em auto;
   background-color: #B8D7F2;
   padding: 0.5em 1em;
   /* border-radius: 1em; */
}
.pre-game.main > .name:before,
.pre-game.main > .name:after {
   content: '';
   display: inline-block;
   width: 2em;
   height: 2.5em;
   background-color: white;
   border-radius: 1em;
   margin: -0.5em -2em;
}
.pre-game.main > .name:before {
   float: left;
}
.pre-game.main > .name:after {
   float: right;
}

.pre-game.main .ruleset {
   margin: 1em auto;
}
.pre-game.main .ruleset .header {
   width: 10em;
   margin: 0.5em auto;
   border-bottom: 1px solid #36516C;
}
.pre-game.main .ruleset .preset {
   padding: 0.5em;
   border-radius: 0.5em;
   border-width: 0px;
   text-align: center;
}
.pre-game.main .ruleset .preset:hover {
   background-color: rgba(55, 80, 110, 0.1);
}

.pre-game.main .toggler {
   display: block;
   width: 0em;
   height: 0em;
   border: 1em solid rgb(100,150,200);
   border-left: 3em solid transparent;
   border-right: 3em solid transparent;
   margin: 0.5em auto;
   cursor: pointer;
}
.pre-game.main .toggler:hover {
   border-color: rgba(100, 150, 200, 0.5) transparent;
}
.pre-game.main .toggler[state="0"] {
   border-top-width: 1em;
   border-bottom-width: 0em;
}
.pre-game.main .toggler[state="1"] {
   border-top-width: 0em;
   border-bottom-width: 1em;
}
.pre-game.main .toggler[state="1"] + * {
   display: auto;
}
.pre-game.main .toggler[state="0"] + * {
   display: none;
}

.pre-game.main .ruleset .rules {
   width: 20em;
   margin: auto;
}
.pre-game.main .ruleset .rules .rule:hover {
   background-color: rgba(55, 80, 110, 0.1);
}
.pre-game.main .ruleset .rules .rule > .title {
   display: inline-block;
   width: 10em;
   text-align: left;
}
.pre-game.main .ruleset .rules .rule > .title:after {
   content: ':';
}
.pre-game.main .ruleset .rules .rule > .value {
   display: inline-block;
   width: 5em;
   text-align: center;
}

.pre-game.main .players {
   margin: 1em auto;
}
.pre-game.main .players .header {
   width: 10em;
   margin: 0.5em auto;
   border-bottom: 1px solid #36516C;
}
.pre-game.main .players .slots {
   margin: 0.5em auto;
   width: 20em;
}
.pre-game.main .players .slots .slot {
   height: 1.5em;
   margin: 0.25em auto;
   padding: 0.25em 1em;
   background-color: #C2E3FF;
   border-radius: 1em;
   overflow: visible;
   text-align: left;
}
.pre-game.main .players .slots .slot.empty {
   text-align: center;
}
.pre-game.main .players .slots .slot .player-name {
   font-style: italic;
   font-size: 1.05em;
}
.pre-game.main .players .slots .slot .option {
   float: right;
   margin: 0.25em 0.25em -0.25em;
}
.pre-game.main .players .slots .slot .option.promote {
   display: inline-block;
   cursor: pointer;
   overflow: hidden;
   width: 0em;
   height: 0em;
   border-style: solid;
   border-color: transparent;
   border-bottom: 0.75em solid #6496C8;
   border-left-width: 0.5em;
   border-right-width: 0.5em;
}
.pre-game.main .players .slots .slot .option.kick {
   display: inline-block;
   cursor: pointer;
   overflow: hidden;
   width: 0em;
   height: 0em;
   border-style: solid;
   border-color: transparent;
   border-left: 0.75em solid #6496C8;
   border-top-width: 0.5em;
   border-bottom-width: 0.5em;
}
.pre-game.main .players .slots .slot .position {
   margin-right: 1.5em;
   margin-left: 0.5em;
   cursor: move;
}
.pre-game.main .players .slots .slot .position:before {
   content: '';
   float: left;
   display: inline-block;
   width: 1.5em;
   height: 1.5em;
   margin-right: -1.5em;
   margin-bottom: -1.5em;
   background-color: rgba(55, 80, 110, 0.5);

   transform: rotate(45deg);
   -ms-transform: rotate(45deg); /* IE 9 */
   -webkit-transform: rotate(45deg); /* Safari and Chrome */
   -o-transform: rotate(45deg);
}

.pre-game.main .actions button {
   margin: 1em 2em;
}

.pre-game.main button {
   font-weight: bold;
   padding: 0.5em 1em;
   border-radius: 1em;
   text-align: center;
   background-color: #4D7399;
   cursor: pointer;
}
EOT;
      }

      if (isset($_REQUEST['ingame']) || count($_REQUEST)==1)
      {
         echo <<<EOT
body {
   background-color: #8CAB35;
}


.cards,
.opponents .player .hand {
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
   cursor: pointer;
   color: black; /* #36516C; */
   text-decoration: none;
   font-weight: bold;
   background-color: rgba(100, 150, 200, 0.5);
   box-shadow: 0em 0em 0.5em 0.5em rgba(100, 150, 200, 0.5);
}
.action:hover {
   /* color: black; */
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

.scoreboard {
   display: block;
   width: 80%;
   margin: 5% auto 0%;
}
.scoreboard > .player {
   display: block;
   margin: 2em 0em;
   padding: 1em;
   border-radius: 1em;
   background-color: rgba(170, 205, 65, 1);
   box-shadow: 0px 0px 5px 5px rgba(170, 205, 65, 1);
   width: auto;
   overflow: auto;
}
.scoreboard > .player > .name {
   font-size: 1.1em;
   font-weight: bold;
   text-align: center;
}
.scoreboard > .player > .total.points {
   font-size: 1.5em;
   text-align: center;
   margin-bottom: 0.5em;
}
.scoreboard > .player > .total.points:after {
   content: ' points';
   font-size: 0.67em;
}
.scoreboard > .player > .hands > .hand {
   display: inline-block;
   padding-right: 3.75em;
   float: left;
}
.scoreboard > .player > .hands > .hand:not(:last-of-type) {
   margin-right: 2em;
}
.scoreboard > .player > .hands > .hand > .card {
   display: inline-block;
   width: 0.5em;
}
.scoreboard > .player > .hands > .hand > .score {
   display: block;
   margin: 0em -1.75em 0.25em 1.75em;
   text-align: center;
}
.scoreboard > .player > .hands > .hand > .score > .bonus.points:before {
   content: '+ ';
}
.scoreboard > .player > .hands > .hand > .score > .hand.points:before {
   content: '= ';
}
.scoreboard > .player > .hands > .hand > .score > .points {
   display: inline-block;
}

.scoreboard .back[name="fixed"] {
   position: fixed;
   top: 15%;
   left: 0.75em;
}
.scoreboard .back:not([name="fixed"]) {
   display: block;
   width: 2em;
   margin-left: auto;
   margin-right: auto;
}
.scoreboard .back {
   color: inherit;
   font-weight: bold;
   text-decoration: none;

   padding: 1em;
   border-top-right-radius: 2em;
   border-bottom-left-radius: 2em;
   background-color: rgba(100, 150, 200, 0.5);
   box-shadow: 0em 0em 0.5em 0.5em rgba(100, 150, 200, 0.5);
}
.scoreboard .back:hover {
   text-decoration: underline;
   background-color: rgba(100, 150, 200, 1);
   box-shadow: 0em 0em 0.5em 0.5em rgba(100, 150, 200, 1);
}
EOT;
      }

   exit;
   }
}

js:
{
   if (isset($_REQUEST['js']))
   {
      if (isset($_REQUEST['call']) || count($_REQUEST)==1)
      {
         echo '   xmlhttp = new Array();'."\n";
         echo "\n";
         echo 'function call(url, callback, sync){'."\n";
         echo '   async = (typeof callback == "boolean")? !callback : (sync!=null)? !sync : true;'."\n";
         echo "\n";
         echo '   if(window.XMLHttpRequest)'."\n";
         echo '      var xh = new XMLHttpRequest();'."\n";
         echo '   else'."\n";
         echo '   if(window.ActiveXObject)'."\n";
         echo '      var xh = new ActiveXObject("Microsoft.XMLHTTP");'."\n";
         echo '   else'."\n";
         echo '      return false;'."\n";
         echo "\n";
         echo "\n";
         echo '   if(typeof callback != "boolean" && callback!=null)'."\n";
         echo '      xh.onreadystatechange = function(){'."\n";
         echo '         if (this.readyState==4 && this.status==200)'."\n";
         echo '            callback(this.responseText);'."\n";
         echo '         xmlhttp.splice(xmlhttp.indexOf(this), 1);'."\n";
         echo '      }'."\n";
         echo "\n";
         echo '   xh.open("GET", url, async);'."\n";
         echo '   xh.send(null);'."\n";
         echo "\n";
         echo '   xmlhttp.push(xh);'."\n";
         echo '   return async? xh : xh.responseText;'."\n";
         echo '}'."\n";
      }

      if (isset($_REQUEST['poll']) || count($_REQUEST)==1)
      {
         if (count($_REQUEST) > 1 && !isset($_REQUEST['call']))
         {
            header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?js&call&poll");
            exit;
         }

         echo 'lastpollcall  = false;'."\n";
         echo 'lastpollstate = false;'."\n";
         echo "\n";
         echo 'function poll (pollfor, state) {'."\n";
         echo '   if (!pollfor && !lastpollcall) return false;'."\n";
         echo '   if (!pollfor){ pollfor = lastpollcall; state = lastpollstate; }'."\n";
         echo "\n";
         echo '   lastpollcall = pollfor; lastpollstate = state;'."\n";
         echo "\n";
         echo '   call("?poll="+pollfor+(!state? "" : "&state="+state), pollanswer);'."\n";
         echo '}'."\n";
         echo "\n";
         echo '   function pollanswer (t) {'."\n";
         echo '      if(t=="1")'."\n";
         echo '         window.location.href="?";'."\n";
         echo '      else'."\n";
         echo '         poll();'."\n";
         echo '   }'."\n";
      }

      if (isset($_REQUEST['clean']) || count($_REQUEST)==1)
      {
         echo 'function clean () {'."\n";
         echo '   if (typeof xmlhttp != "undefined")'."\n";
         echo '   {'."\n";
         echo '      var i;'."\n";
         echo '      for (i=0; i<xmlhttp.length; i++)'."\n";
         echo '      {'."\n";
         echo '         xmlhttp[i].abort();'."\n";
         echo '      }'."\n";
         echo '   }'."\n";
         echo '}'."\n";
      }

      if (isset($_REQUEST['movables']))
      {
         echo <<<EOT
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
      window.location.href='?update&pid='+(currently_dragged.index - currently_dragged.change)+'&chg='+(currently_dragged.change);
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
EOT;
      echo '      if (i < ind) correction -= '.(2*em).'; //2em';
      echo <<<EOT

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
EOT;
      }

      if (isset($_REQUEST['loadingOverhaul']))
      {
         echo <<<EOT
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

   var link = "";

   var r = call(ao_link, true); link = ao_link;
   var redir_link = false;

   while (r.indexOf("<body>") == -1)
   {
      r = r.replace(/<\/?script.*?>/gi, "");
      r = r.replace(/window\.location\.href/g, "redir_link");
      eval( r );

      if (!redir_link)
      {
         window.location.reload();
         return true;
      }

      r = call(redir_link, true); link = redir_link;
   }

   window.location.href = link;
   return true;
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

if (!play())
{
   play = function (card) {
      pollanswer("1", "?play="+card);
   }
}
EOT;
      }

   exit;
   }
}

login_queries:
{
   if (isset($_REQUEST['login'], $_REQUEST['s1']))
   {
      if (isset($_REQUEST['check']))
      {
         $usr = mysql_real_escape_string($_REQUEST['check']);
         if (mysql_("SELECT Username FROM rsk_users WHERE Username='$usr'", true) > 0)
            echo "s2";
         else
            echo "s3";
         exit;
      }else
         echo "";

      exit;
   }
   if (isset($_REQUEST['login'], $_REQUEST['s2']))
   {
      $usr = mysql_real_escape_string($_REQUEST['username']);
      $pwd = md5($_REQUEST['password']);

      $p = mysql_("SELECT SID FROM rsk_users WHERE Username='$usr' AND Password='$pwd'");
      mysql_query("UPDATE rsk_users SET SID='".session_id()."' WHERE Username='$usr' AND Password='$pwd'") or die(mysql_error());

      if (mysql_affected_rows() > 0)
      {
         $_SESSION['user'] = $usr;

         if (isset($_REQUEST['remusr']) && $_REQUEST['remusr'])
            setcookie('remember', $usr, time() + 2592000); //expire after 30 days

         if (isset($_REQUEST['stayin']) && $_REQUEST['stayin'])
            setcookie('stayin', session_id(), time() + 2592000); //expire after 30 days

         //Success
         echo '<script type="text/javascript">window.location.href="?silent&clean='.$p.'";</script>'."\n";
         exit;
      }

      //Failure
      echo '<script type="text/javascript">window.location.href="?login&fail";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['login'], $_REQUEST['s3']))
   {
      $usr = mysql_real_escape_string($_REQUEST['username']);
      $pwd = md5($_REQUEST['password']);

      mysql_query("INSERT INTO rsk_users (Username, Password, SID) VALUES ('$usr', '$pwd', '".session_id()."')");

      if (mysql_affected_rows() > 0)
      {
         $_SESSION['user'] = $usr;

         //Success
         echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
         exit;
      }

      //Failure
      echo '<script type="text/javascript">window.location.href="?login&fail";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['logout']))
   {
      $usr = $_SESSION['user'];
      unset($_SESSION['user']);
      header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?clean=$usr");
      exit;
   }
   if (isset($_REQUEST['clean']))
   {
      $c = mysql_real_escape_string($_REQUEST['clean']);

      $p = mysql_("SELECT Username FROM rsk_users WHERE SID = '$c' OR Username = '$c' LIMIT 1");
      if ($p !== false)
      {
         mysql_query("UPDATE rsk_users SET SID=NULL WHERE Username='$p'");

         $q = mysql_query("SELECT GameID FROM rsk_players WHERE Player='$p' AND Finished=0");

         while($v = mysql_fetch_array($q, MYSQL_ASSOC))
            $left_games[] = $v['GameID'];

         if (!isset($left_games))
            $left_games = array();
      }
      else
      {
         if (mysql_("SELECT GID FROM rsk_games WHERE GID='$c'", true) > 0)
            $left_games = array($c);
         else
         {
            if (!isset($_REQUEST['silent']))
            {
               echo '<div>There was nothing to clean!</div>'."\n";
               echo '<a href="?">Home</a>'."\n";
            }
            else
               echo '<script type="text/javascript">window.location.href="?";</script>'."\n";

            exit;
         }
      }

      foreach ($left_games as $gid)
      {
         mysql_("DELETE FROM rsk_games WHERE GID=$gid");
         mysql_("DELETE FROM rsk_players WHERE GameID=$gid");
         mysql_("DELETE FROM rsk_turns WHERE GameID=$gid");
         mysql_("DELETE FROM rsk_decks WHERE GameID=$gid");
         mysql_("DELETE FROM rsk_status WHERE `Key`='game:$gid'");
      }

      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
}


restriction:
{
   if (!isset($_SESSION['user']) && count($_REQUEST) > 0)
   {
      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
}


polling:
{
   if (isset($_REQUEST['poll']))
   {
      //exit;
      $key = mysql_real_escape_string($_REQUEST['poll']);

      if (mysql_("SELECT `Key` FROM rsk_status WHERE `Key`='$key' LIMIT 1", true) != 1)
      {
         // No such status key
         echo "-1";
         exit;
      }

      if (!isset($_REQUEST['state']) || strlen(trim($_REQUEST['state']))==0)
         $_REQUEST['state'] = mysql_("SELECT `Value` FROM rsk_status WHERE `Key`='$key' LIMIT 1");

      $s_ = intval($_REQUEST['state']);

      set_time_limit(0);
      session_write_close();

      $timeout = 30; //seconds
      // Wait and listen for a change
      do
      {
         if ($timeout-- <= 0)
            break;

         sleep(1);
         $state = mysql_("SELECT `Value` FROM rsk_status WHERE `Key`='$key' LIMIT 1");
      }
      while ($state == $s_);

      if ($timeout <= 0)
         echo "0";
      else
         echo "1";

      exit;
   }
}

queries:
{
   if (isset($_REQUEST['newgame']))
   {
      $gid_m = mysql_("SELECT GID FROM rsk_games ORDER BY GID DESC LIMIT 1");
      $gid_c = mysql_("SELECT GID FROM rsk_games", true);
      if ($gid_m == $gid_c)
         $gid = $gid_c + 1;
      else
      {
         $gid = 1;
         $gs = mysql_("SELECT GID FROM rsk_games ORDER BY GID ASC", MYSQL_TABLE);
         foreach ($gs as $k=>$v)
            if ($k+1 != $v)
            {
               $gid = $k+1;
               break;
            }
      }

      $name = mysql_real_escape_string($_SESSION['user'] . "'s game");

      mysql_("INSERT INTO rsk_games (GID, Name, Host) VALUES ($gid, '$name', '".$_SESSION['user']."')") or die(mysql_error());
      mysql_("INSERT INTO rsk_players (Player, GameID, PID) VALUES ('".$_SESSION['user']."', $gid, 1)") or die(mysql_error());

      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1, ".status_margin.") WHERE `Key`='lobby'");
      mysql_("INSERT INTO rsk_status (`Key`, `Value`) VALUES ('game:$gid', 0)");

      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['join']))
   {
      $gid = intval($_REQUEST['join']);

      $slots  = intval(mysql_("SELECT PlayerCount FROM rsk_games WHERE GID=$gid"));
      $joined = mysql_("SELECT GameID FROM rsk_players WHERE GameID=$gid", true);

      if ($slots > $joined)
      {
         $q = mysql_("SELECT PID FROM rsk_players WHERE GameID=$gid ORDER BY PID DESC LIMIT 1", MYSQL_ASSOC);
         $pid = intval($q['PID'])+1;

         mysql_("INSERT INTO rsk_players (Player, GameID, PID) VALUES ('".$_SESSION['user']."', $gid, $pid)") or die(mysql_error());

         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:$gid'");
      }

      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['update']))
   {
      $g = mysql_("SELECT p.GameID as gid, p.PID as my_pid, g.Host as host FROM rsk_players as p, rsk_games as g WHERE p.GameID=g.GID AND p.Player='".$_SESSION['user']."' AND p.Finished=0 LIMIT 1", MYSQL_ASSOC);
      if ($_SESSION['user'] != $g['host'])
      {
         echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
         exit;
      }

      $setstring = "";
      if (isset($_REQUEST['playerCount']))  $setstring .= ", PlayerCount=". intval($_REQUEST['playerCount']);
      if (isset($_REQUEST['startingHand'])) $setstring .= ", startingHand=".intval($_REQUEST['startingHand']);
      if (isset($_REQUEST['forcedAnswer'])) $setstring .= ", forcedAnswer=".intval($_REQUEST['forcedAnswer']);
      if (isset($_REQUEST['forcedRaise']))  $setstring .= ", forcedRaise=". intval($_REQUEST['forcedRaise']);
      if (isset($_REQUEST['turnDraw']))     $setstring .= ", turnDraw=".    intval($_REQUEST['turnDraw']);
      if (isset($_REQUEST['takeDraw']))     $setstring .= ", takeDraw=".    intval($_REQUEST['takeDraw']);
      if (isset($_REQUEST['emptyDraw']))    $setstring .= ", emptyDraw=".   intval($_REQUEST['emptyDraw']);
      $setstring = ltrim($setstring, ",");

      if ($setstring != "")
      {
         mysql_("UPDATE rsk_games SET $setstring WHERE GID=".$g['gid']);
         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");
      }

      if (isset($_REQUEST['pid'], $_REQUEST['chg']))
      {
         $pid = intval($_REQUEST['pid'])+1;
         $chg = intval($_REQUEST['chg']);

         if ($chg == 0)
         {
            echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
            exit;
         }

         mysql_("UPDATE rsk_players SET PID=0 WHERE GameID=".$g['gid']." AND PID = ".$pid) or die(mysql_error());

         if ($chg < 0)
            mysql_("UPDATE rsk_players SET PID=PID+1 WHERE GameID=".$g['gid']." AND PID >= ".($pid+$chg)." AND PID < ".$pid);
         else
            mysql_("UPDATE rsk_players SET PID=PID-1 WHERE GameID=".$g['gid']." AND PID > ".$pid." AND PID <= ".($pid+$chg));

         mysql_("UPDATE rsk_players SET PID=".($pid+$chg)." WHERE GameID=".$g['gid']." AND PID = 0");
         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");
      }

      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['promote'])){
      $g = mysql_("SELECT p.GameID as gid, p.PID as my_pid, g.Host as host FROM rsk_players as p, rsk_games as g WHERE p.GameID=g.GID AND p.Player='".$_SESSION['user']."' AND p.Finished=0 LIMIT 1", MYSQL_ASSOC);

      if ($_SESSION['user'] != $g['host'])
      {
         echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
         exit;
      }

      $promotee = mysql_real_escape_string($_REQUEST['promote']);

      if (mysql_("SELECT 1 FROM rsk_players WHERE GameID=".$g['gid']." AND Player='".$promotee."' AND Finished=0", true) <= 0)
      {
         echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
         exit;
      }

      if ($promotee == $g['host'])
      {
         echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
         exit;
      }

      mysql_("UPDATE rsk_games SET Host='$promotee' WHERE GID=".$g['gid']);
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");

      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['leavegame']))
   {
      $g = mysql_("SELECT p.GameID as gid, p.PID as my_pid FROM rsk_players as p WHERE p.Player='".$_SESSION['user']."' AND p.Finished=0 LIMIT 1", MYSQL_ASSOC);

      mysql_("DELETE FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0");
      mysql_("UPDATE rsk_players SET PID=PID-1 WHERE GameID=".$g['gid']." AND PID>".$g['my_pid']);

      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");

      $c = mysql_("SELECT 1 FROM rsk_players WHERE GameID=".$g['gid'], true);
      if ($c == 0)
      {
         mysql_("DELETE FROM rsk_games WHERE GID=".$g['gid']);

         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='lobby'");
         mysql_("DELETE FROM rsk_status WHERE `Key`='game:".$g['gid']."'");
      }

      echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['startgame']))
   {
      $g = mysql_("SELECT p.GameID as gid, p.PID as my_pid, g.Host as host, g.PlayerCount as playerCount, g.startingHand as startingHand FROM rsk_players as p, rsk_games as g WHERE p.GameID=g.GID AND p.Player='".$_SESSION['user']."' AND p.Finished=0 LIMIT 1", MYSQL_ASSOC);

      if ($_SESSION['user'] != $g['host'])
      {
         echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
         exit;
      }

      $playersIn = mysql_("SELECT 1 FROM rsk_players WHERE GameID=".$g['gid']." AND Finished=0", true);
      if ($g['playerCount'] != $playersIn)
      {
         echo "Not enough players<br />\n";
         echo '<a href="?">Back</a>'."\n";
         echo '<script type="text/javascript"> setTimeout(\'window.location.href="?";\', 3000); </script>'."\n";
         exit;
      }


      //Prepare Deck
      $allcards = mysql_("SELECT Card FROM rsk_cards", MYSQL_NUM);

      //    suffle deck
      shuffle($allcards);

      //    apply deck
      $valstring = "";
      foreach ($allcards as $p=>$c)
      {
         if ($valstring!="")
            $valstring .= ", ";

         $valstring .= "(".$g['gid'].", $p, '$c')";
      }

      mysql_("INSERT INTO rsk_decks (GameID, Position, Card) VALUES $valstring");


//      //Deal Starting Hand
//      $details = mysql_("SELECT PlayerCount, startingHand FROM rsk_games WHERE GID=".$g['gid']." LIMIT 1", MYSQL_ASSOC);
//
//      $dealt = 0;
//      $p = 0;
//
//      while ($dealt < $details['startingHand'] * $details['PlayerCount'])
//      {
//         $pc = mysql_("SELECT 1 FROM rsk_turns WHERE GameID=".$g['gid']." AND Player=".($p+1)."", true);
//
//         for ($j=0; $j < cardsPerDeal; $j++)
//         {
//            if ($pc + $j >= $details['startingHand'])
//               break;
//
//            $card = mysql_("SELECT Card FROM rsk_decks WHERE GameID=".$g['gid']." AND Position=".$dealt);
//            $g['Turn'] = mysql_("SELECT MAX(Turn) FROM rsk_turns WHERE GameID=".$g['gid']);
//            mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES (".$g['gid'].", ".($g['Turn']+1).", ".($p+1).", 'Draw', '".$card."')") or die(mysql_error());
//
//            $dealt++;
//         }
//
//         $p = (++$p) % $details['PlayerCount'];
//      }

      // Status update
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='lobby'");
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");

      // Deal Starting Hand
      $_SESSION['deal'] = $g['startingHand'];
      echo '<script type="text/javascript">window.location.href="?parse='.$g['gid'].'&back=?deal"</script>'."\n";
      exit;
   }

   if (isset($_REQUEST['play']))
   {
      //$g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1", MYSQL_ASSOC);
      $g = &$_SESSION['game'];

      $card = mysql_real_escape_string($_REQUEST['play']);
      if (mysql_("SELECT Card FROM rsk_cards WHERE Card='$card' LIMIT 1", true) == 0)
      {
         echo "No such card!";
         exit;
      }


      // check if its player's turn
      // check if the player actually has this card
      // check if is allowed to play the card
      //    see rule:forcedAnswer
      //    see rule:forcedRaise



      // if the action is hand-initializing
      //    if rule:turnDraw is enabled
      //       if there are NO draw actions yet
      //          $_SESSION['deal'] = 1
      //          ?deal
      ////take extra care for parsing


      // play the card
      //$g['Turn'] = mysql_("SELECT MAX(Turn) FROM rsk_turns WHERE GameID='".$g['GameID']."'");
      $my_pid = null;
      foreach ($g['players'] as $p)
         if ($p['name'] == $_SESSION['user'])
            $my_pid = $p['pid'];

      mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['gid']."', ".($g['turn']+1).", '".$my_pid."', 'Play', '$card')");


      // -obsolete- if the action is hand-finilizing
      //    if hands of all players are empty
      //       if rule:emptyDraw is enabled
      //          $_SESSION['deal'] = rule:emptyDraw
      //          ?deal

      //       //else
      //          //?takecards
      //       /// Players need to see what happened, this gives no time

      $s = -1; //account for the currently played card
      foreach ($g['players'] as $p)
         $s += count($p['cards']);

      if ($s == 0)
      {
         if ($g['rules']['emptyDraw'] === 0)
         {
            //echo '<script type="text/javascript"> window.location.href="?takecards"; </script>'."\n";
            echo '<script type="text/javascript"> window.location.href="?parse='.$g['gid'].'"; </script>'."\n";
            exit;
         }
         else
         {
            $_SESSION['deal'] = $g['rules']['emptyDraw'];
            echo '<script type="text/javascript"> window.location.href="?parse='.$g['gid'].'&back=?deal"; </script>'."\n";
            exit;
         }
      }


      // status update
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");

      echo '<script type="text/javascript">window.location.href="?parse='.$g['gid'].'"</script>'."\n";
      //echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['takecards']))
   {
      //$g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1", MYSQL_ASSOC);
      $g = &$_SESSION['game'];

      // check if it is player's turn
      // check if the player won the last hand

      // take set cards
      //$g['Turn'] = mysql_("SELECT MAX(Turn) FROM rsk_turns WHERE GameID='".$g['GameID']."'");
      mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['gid']."', ".($g['turn']+1).", '".$g['onturn']."', 'Take', NULL)");

      // status update
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");

      // see rule:takeDraw
      //    if enabled
      //       - set $_SESSION['deal'] = ?deal=
      //       ?deal

      if ($g['rules']['takeDraw'] > 0)
      {
         $_SESSION['deal'] = count($g['sethands']) - 1;
         echo '<script type="text/javascript">window.location.href="?parse='.$g['gid'].'&back=?deal"</script>'."\n";
         exit;
      }


      echo '<script type="text/javascript">window.location.href="?parse='.$g['gid'].'"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['deal']))
   {
      //$g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1", MYSQL_ASSOC);
      $g = &$_SESSION['game'];

      // check if this is a direct call
      //    if $_SESSION['deal'] is not set die

      if (!isset($_SESSION['deal']))
      {
         //echo '<a href="?">Onwards</a>';
         echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
         exit;
      }
      else
      {
         $deal = $_SESSION['deal'];
         unset($_SESSION['deal']);
      }

      // if no cards left to deal and no cards in hands
      //    - set $_SESSION['dealt']
      //    ?finalize

      $s = 0;
      foreach ($g['players'] as $p)
         $s += count($p['cards']);

      $cards_inDeck = count($g['cards']['indeck']);

      if ($cards_inDeck == 0 && $s == 0)
      {
         $_SESSION['dealt'] = true;
         //echo '<a href="?parse='.$g['gid'].'&back=?finalize">Onwards</a>';
         echo '<script type="text/javascript">window.location.href="?parse='.$g['gid'].'&back=?finalize"</script>'."\n";
         exit;
      }

      // check if there are enough cards in the deck
      //    if $_SESSION['deal'] * playerCount > cardsLeft
      //       divide equally


         $playerCount = count($g['players']);
      if ($deal * $playerCount > $cards_inDeck)
      {
            $o = $cards_inDeck % $playerCount;
         $deal = ($cards_inDeck - $o) / $playerCount;
      }

      // deal the appropriate number of cards

         $dealt = 0;
         $p = 0;

         $pc = array(); //player_cards
         for ($i=0; $i < $playerCount; $i++)
            $pc[$i+1] = 0;

            $drawncards = count($g['cards']['drawn']);

         while ($dealt < $deal * $playerCount)
         {
            for ($j=0; $j < cardsPerDeal; $j++)
            {
               if ($pc[$p+1] + 1 > $deal)
                  break;

               $card = mysql_("SELECT Card FROM rsk_decks WHERE GameID='".$g['gid']."' AND Position=".($drawncards + $dealt));
               $turn = $g['turn'] + $dealt;
               mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['gid']."', ".($turn+1).", ".($p+1).", 'Draw', '".$card."')") or die(mysql_error());

               $dealt++;
               $pc[$p+1]++;
               $cards_inDeck--; //needed later in the script
            }

            $p = (++$p) % $playerCount;
         }


      // status update
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");

      // check for left-over cards
      //    if cardsLeft < playerCount
      //       remove last n cards from play

      if ($cards_inDeck < $playerCount)
      {
            $allcards = count($g['cards']['all']);
         for ($i=0; $i < $cards_inDeck; $i++)
         {
            $card = mysql_("SELECT Card FROM rsk_decks WHERE GameID='".$g['gid']."' AND Position=".($allcards - ($cards_inDeck - $i)));
            $turn = $g['turn'] + $dealt + $i;
            mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['gid']."', ".($turn+1).", -1, 'Draw', '".$card."')") or die(mysql_error()); // Player=-1 basically removes the card from play
            //$cards_inDeck--; //might mess with the for-loop
         }
      }

      echo '<script type="text/javascript">window.location.href="?parse='.$g['gid'].'"</script>'."\n";
      //echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['finalize']))
   {
      //$g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1", MYSQL_ASSOC);
      $g = &$_SESSION['game'];

      // check if this is a direct call
      //    if $_SESSION['dealt'] is not set ?_

      if (!isset($_SESSION['dealt']))
      {
         echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
         exit;
      }
      else
         unset($_SESSION['dealt']);


      // coming from ?deal should ensure these:
      //  --- check if deck is empty
      //  --- check if hands are empty


      // check (using &$g) if there are untaken cards
      //    if so, insert Take

      if (count($g['sethands']) > 0)
      {
         $turn = mysql_("SELECT GameID FROM rsk_turns WHERE GameID=".$g['gid'], true);
         mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES (".$g['gid'].", ".($turn+1).", ".$g['onturn'].", 'Take', NULL)");

         $_SESSION['dealt'] = true;
         echo '<script type="text/javascript">window.location.href="?parse='.$g['gid'].'&turn='.($g['turn']+1).'&back=?finalize"</script>'."\n";
         exit;
      }


      // set finished flags in rsk_players

      mysql_("UPDATE rsk_players SET Finished=1 WHERE GameID='".$g['gid']."' AND Player='".$_SESSION['user']."'");


      // if all players are "finished", clean the game

      if (0==mysql_("SELECT Finished FROM rsk_players WHERE GameID=".$g['gid']." AND Finished=0", true))
      {
         // clean rsk_decks

         mysql_("DELETE FROM rsk_decks WHERE GameID='".$g['gid']."'");


         // update status for lobby
         // remove status entry game:$gid

         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='lobby'");
         mysql_("DELETE FROM rsk_status WHERE `Key`='game:".$g['gid']."'");
      }
      else
      {
         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['gid']."'");
      }


      //$turns = mysql_("SELECT GameID FROM rsk_turns WHERE GameID='".$g['gid']."'", true);
      $my_pid = null;
      foreach ($g['players'] as $p)
         if ($p['name'] == $_SESSION['user'])
            $my_pid = $p['pid'];

      echo '<script type="text/javascript">window.location.href="?observe='.$g['gid'].'&view='.$my_pid.'&turn='.($g['turn']+1).'"</script>'."\n";
      exit;
   }
}

parse:
{
   if (isset($_REQUEST['dump']))
   {
      echo "<pre>",var_dump($_SESSION['game']),"</pre>";
      exit;
   }

   if (isset($_REQUEST['parse']))
   {
      // This is meant to fill $_SESSION['game'] with the appropriate content

      $gid = mysql_real_escape_string($_REQUEST['parse']);
      if (trim($gid) == '')
      {
         $implicit = true;
         $gid = mysql_("SELECT GameID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1");
      }
      else
         $implicit = false;

      if (mysql_("SELECT GID FROM rsk_games WHERE GID=$gid", true) == 0)
      {
         echo "Couldn't find specified game (id: $gid)"."\n";
         echo '<a href="?">Back</a>'."\n";
         echo '<script type="text/javascript">setTimeout(\'window.location.href="?";\', 0);</script>'."\n";
         exit;
      }


      $g = &$_SESSION['game'];



      if ($implicit || !isset($_SESSION['game']) || $_SESSION['game']['gid']!=$gid)
      {
         $_SESSION['game'] = array();


         $g['gid'] = $gid;
         $q = mysql_("SELECT * FROM rsk_games WHERE GID=$gid LIMIT 1", MYSQL_ASSOC);

         $g['name'] = $q['Name'];
         $g['timestamp'] = $q['Played'];
         $g['host'] = $q['Host'];

         $g['rules'] = array(
            "playerCount"  =>$q['PlayerCount'],
            "startingHand" =>$q['startingHand'],
            "turnDraw"     =>$q['turnDraw'],
            "emptyDraw"    =>$q['emptyDraw'],
            "takeDraw"     =>$q['takeDraw'],
            "forcedAnswer" =>$q['forcedAnswer'],
            "forcedRaise"  =>$q['forcedRaise']
         );


         $g['players'] = array();
         $p = mysql_("SELECT Player, PID FROM rsk_players WHERE GameID=$gid");

         foreach ($p as $v)
         {
            $g['players'][$v['PID']] = array(
               "name"  =>$v['Player'],
               "pid"   =>$v['PID'],
               "cards" =>array(),
               "takes" =>array()
            );
         }


         $g['finished'] = 0==mysql_("SELECT Finished FROM rsk_players WHERE GameID=$gid AND Finished=0", true);


         $g['cards']['all'] =
            $g['finished']?
               mysql_("SELECT Card FROM rsk_turns WHERE GameID='$gid' AND Action='Draw' ORDER BY Turn ASC")
               :
               mysql_("SELECT Card FROM rsk_decks WHERE GameID='$gid' ORDER BY Position ASC");
      }




         $g['finished'] = 0==mysql_("SELECT Finished FROM rsk_players WHERE GameID=$gid AND Finished=0", true);

         if (isset($_REQUEST['turn']))
            $turn = intval($_REQUEST['turn']);
         else
            $turn = $g['finished']? 0 : mysql_("SELECT GameID FROM rsk_turns WHERE GameID=$gid", true);




      if ($implicit || !isset($_SESSION['game']['turn']) || $g['turn']!=$turn)
      {
         if (!$implicit && isset($_SESSION['game']['turn']))
            $old_turn = $_SESSION['game']['turn'];

         $g['turn'] = $turn;
         $turn = &$g['turn'];


         //$g['cards'] = array("all"=>array(), "drawn"=>array(), "indeck"=>array(), "played"=>array());


            $d = mysql_("SELECT Card FROM rsk_turns WHERE GameID='$gid' AND Action='Draw' AND Turn<=$turn ORDER BY Turn ASC");
         $g['cards']['drawn'] = $d? (is_array($d)? $d : array($d)) : array();

         $g['cards']['indeck'] = array_diff($g['cards']['all'], $g['cards']['drawn']);


         // Start parsing turns

         if (!isset($old_turn) || !($old_turn < $turn))
         {
            foreach ($g['players'] as $k=>$v)
            {
               $g['players'][$k]['cards'] = array();
               $g['players'][$k]['takes'] = array();
            }

            $g['onturn'] = 1; //pid of player currently on turn
            $g['cards']['played'] = array(); //array( array("name"=>"9c", "img"=>"img/9c.png", "fullname"=>"Nine of Clubs") );
            $g['sethands'] = array(); // array(  array( card1, card2 ), array( card3, card4) )
         }


         function act (&$game, $t) //$t /turn/
         {
            if (!isset($game['players'][$t['Player']]))
            {
               var_dump($game['players'], $t['Player']); exit;
               return false;
            }

            if ($t['Action'] == "Draw")
            {
               $game['players'][$t['Player']]['cards'][] =
                  mysql_("SELECT Card as name, Img as img, Fullname as fullname, Power as power, Value as value FROM rsk_cards WHERE Card = '".$t['Card']."' LIMIT 1", MYSQL_ASSOC);
            }

            if ($t['Action'] == "Play")
            {
               //if ($game['onturn'] != $t['Player'])
               //   continue;
               //   //ERROR

               $l = count($game['cards']['played']);
               $game['cards']['played'][$l] =
                  mysql_("SELECT Card as name, Img as img, Fullname as fullname, Power as power, Value as value FROM rsk_cards WHERE Card = '".$t['Card']."' LIMIT 1", MYSQL_ASSOC);
               $game['cards']['played'][$l]["owner"] = $t['Player'];

               $game['onturn'] = (($game['onturn']) % count($game['players'])) +1; //increment pid


               if (count($game['cards']['played']) >= count($game['players']))
               {
                  //Determine winner of hand
                  unset($lead);
                  foreach ($game['cards']['played'] as $card)
                  {
                     if (!isset($lead))
                     {
                        $lead = $card;
                        continue;
                     }

                     if (substr($card['name'], -1) != substr($lead['name'], -1))
                        continue;


                     if ($lead['power'] > $card['power'])
                        continue;

                     $lead = $card;
                  }
                  $game['onturn'] = $lead['owner'];

                     foreach ($game['cards']['played'] as $k=>$v)
                        unset($game['cards']['played'][$k]['owner']);

                  $game['sethands'][] = $game['cards']['played'];
                  $game['cards']['played'] = array();
               }


               foreach ($game['players'][$t['Player']]['cards'] as $k=>$card)
               {
                  if ($card['name'] == $t['Card'])
                     unset($game['players'][$t['Player']]['cards'][$k]);
               }
            }

            if ($t['Action'] == "Take")
            {
               $game['players'][$t['Player']]['takes'][] = $game['sethands'];
               $game['sethands'] = array();
            }
         }

            $adstr = (isset($old_turn) && $old_turn < $turn)? " AND Turn > ".$old_turn : "";
         $turns = mysql_("SELECT Player, Action, Card FROM rsk_turns WHERE GameID='$gid'".$adstr." AND Turn <= $turn ORDER BY Turn ASC", MYSQL_ASSOC|MYSQL_TABLE);
         if (!$turns) $turns = array();

         foreach ($turns as $t)
            act($g, $t);


         $s = count($g['cards']['indeck']);
         foreach ($g['players'] as $p)
            $s += count($p['cards']);
         $s += count($g['sethands'], 1);

         $g['gameover'] = $s==0;

         //if ($game_over && _last_action!=take) insert take ////
      }



      //echo '<a href="'.(isset($_REQUEST['back'])? str_replace("*","&",mysql_real_escape_string($_REQUEST['back'])) : '?').'">Back</a>'."\n";
      //var_dump($g);

      echo '<script type="text/javascript">window.location.href="'.(isset($_REQUEST['back'])? str_replace("*","&",mysql_real_escape_string($_REQUEST['back'])) : '?').'";</script>'."\n";
      exit;
   }
}

observe:
{
   if (isset($_REQUEST['observe']))
   {
      $gid = mysql_real_escape_string($_REQUEST['observe']);
      if (mysql_("SELECT GID FROM rsk_games WHERE GID='$gid'", true) == 0)
      {
         echo "Couldn't find specified game (id: $gid)"."\n";
         echo '<a href="?">Back</a>'."\n";
         echo '<script type="text/javascript">setTimeoit(\'window.location.href="?";\', 3000);</script>'."\n";
         exit;
      }

      $turn = !isset($_REQUEST['turn']) ? 1 : max(1, intval($_REQUEST['turn']));
      $my_pid = !isset($_REQUEST['view']) ? 1 : max(1, intval($_REQUEST['view']));

      if (!isset($_SESSION['game']) || $_SESSION['game']['gid']!=$gid || $_SESSION['game']['turn']!=$turn)
      {
         // parse game
         echo '<script type="text/javascript">window.location.href="?parse='.$gid.'&turn='.$turn.'&back=?observe='.$gid.'*view='.$my_pid.'*turn='.$turn.'";</script>'."\n";
         exit;
      }

      $g = &$_SESSION['game'];

      $can_play = ($g['onturn']==$my_pid);
         // true if current player is on turn
      $can_take = ($g['onturn']==$my_pid) && (count($g['sethands'])>0) && (count($g['cards']['played'])==0);
         // true if current player is: on turn, there are set cards, there are no played cards
      $can_draw = ($g['onturn']==$my_pid) && (count($g['cards']['played'])==0) && $g['rules']['turnDraw'];
         // true if current player is: on turn, there are no played cards, rule:turnDraw is enabled
      // Done with the variables


      echo '<html>'."\n";
      echo '<head>'."\n";
      echo '   <title>Risk Jack - Observe Game</title>'."\n";
      echo '   <script type="text/javascript" src="?js&call&poll&clean"></script>'."\n";
      echo '   <link rel="stylesheet" type="text/css" href="?css&ingame" />'."\n";
      echo '</head>'."\n";

      echo '<body>'."\n";
      echo "\n";


      if ($g['gameover'])
      {
         echo '   <div class="scoreboard">'."\n";

         foreach ($g['players'] as $player)
         {
            echo '      <div class="player score">'."\n";
            echo '         <div class="name">'.$player['name'].'</div>'."\n";
            echo "\n";

            $total_points = 0;
            $buffer = '';

            $buffer .= '         <div class="hands">'."\n";
            $buffer .= "\n";

            foreach ($player['takes'] as $pile)
            {
               $hand_points  = 0;
               $card_points  = 0;
               $bonus_points = count($pile)-1;

               $buffer .= '            <div class="hand">'."\n";
               $buffer .= "\n";

               foreach ($pile as $hand)
               {

                  foreach ($hand as $card)
                  {
                     $card_points += $card['value'];

                     $buffer .= '               <div class="card">'."\n";
                     $buffer .= '                  <img src="'.$card['img'].'" alt="'.$card['fullname'].'" title="'.$card['fullname'].'" />'."\n";
                     $buffer .= '                  <div class="name">'.$card['fullname'].'</div>'."\n";
                     $buffer .= '               </div>'."\n";
                  }

               }
               $hand_points = $card_points + $bonus_points;

               $buffer .= '              <div class="score">'."\n";
               $buffer .= '                  <div class="card points">'.$card_points.'</div>'."\n";
               $buffer .= '                  <div class="bonus points">'.$bonus_points.'</div>'."\n";
               $buffer .= '                  <div class="hand points">'.$hand_points.'</div>'."\n";
               $buffer .= '               </div>'."\n";

               $buffer .= "\n";
               $buffer .= '            </div>'."\n";

               $total_points += $hand_points;
            }

            $buffer .= '         </div>'."\n";

            echo '         <div class="total points">'.$total_points.'</div>'."\n";

            echo $buffer;

            echo '      </div>'."\n";
         }

         echo '      <a href="?" class="back">Exit</a>'."\n";
         ////
         //echo '      <a href="?" class="back fixed">Exit</a>'."\n";
         //echo '<script type="text/javascript">onscroll</script>'."\n";

         echo '   </div>'."\n";

         echo "\n";
         echo '</body>'."\n";
         echo '</html>'."\n";
         exit;
      }


      // Deck Section

      echo '<div class="deck">'."\n";
      echo '   <div class="cards">'."\n";
      echo '      <div class="card">'."\n";
      echo '         <img src="img/back.png" alt="Back of Card" title="Back of Card" />'."\n";
      echo '         <div class="name">Back of Card</div>'."\n";
      echo '      </div>'."\n";
      echo '   </div>'."\n";
      echo "\n";
      echo '   <div class="description">'."\n";
      echo '      <span class="number">'.count($g['cards']['indeck']).'</span>'."\n";
      echo '      <div class="clarification">in deck</div>'."\n";
      echo '   </div>'."\n";
      echo '</div>'."\n";


      // Notice Section

      echo '<div class="turn notice">'."\n";
      echo '   '.($g['onturn'] == $my_pid ? "Your turn" : $g['players'][$g['onturn']]['name']."'s turn")."\n";
      echo '</div>'."\n";


      // Played Hand Section

      echo '<div class="played hand">'."\n";
      echo '   <div class="header">Played cards:</div>'."\n";
      echo "\n";
      echo '   <div class="cards">'."\n";
      echo "\n";
      foreach ($g['cards']['played'] as $card)
      {
         echo '      <div class="card">'."\n";
         echo '         <img src="'.$card['img'].'" alt="'.$card['fullname'].'" title="'.$card['fullname'].'" />'."\n";
         echo '         <div class="name">'.$card['fullname'].'</div>'."\n";
         echo '      </div>'."\n";
      }
      echo "\n";
      echo '   </div>'."\n";
      echo '</div>'."\n";


      // Set Hands Section

      echo '<div class="set hand">'."\n";
      echo '   <div class="cards">'."\n";
      echo "\n";

      $lastHand = end($g['sethands']);
      if (!$lastHand) $lastHand = array();
      foreach ($lastHand as $card)
      {
         echo '      <div class="last-hand card">'."\n";
         echo '         <img src="'.$card['img'].'" alt="'.$card['fullname'].'" title="'.$card['fullname'].'" />'."\n";
         echo '         <div class="name">'.$card['fullname'].'</div>'."\n";
         echo '      </div>'."\n";
      }

      for ($i=1; $i < count($g['sethands']); $i++)
      {
         echo '      <div class="card">'."\n";
         echo '         <img src="img/back.png" alt="Back of Card" title="Back of Card" />'."\n";
         echo '         <div class="name">Back of Card</div>'."\n";
         echo '      </div>'."\n";
      }

      echo "\n";
      echo '   </div>'."\n";
      echo "\n";
      echo '   <div class="description">'."\n";
      echo '      <span class="number">'.count($g['sethands']).'</span>'."\n";
      echo '      <div class="clarification">set hand'.(count($g['sethands'])!=1 ? "s" : "&nbsp;").'</div>'."\n";
      echo '   </div>'."\n";
      echo "\n";
      if ($can_take)
      {
         echo '   <div class="action">'."\n";
         echo '      <a href="#takecards">Take</a>'."\n";
         echo '   </div>'."\n";
      }
      echo '</div>'."\n";


      // Current Player's Hand Section

      echo '<div class="player hand'.(($can_play&&!$can_draw) ? "" : " unavailable").'">'."\n";
      echo '   <div class="header">Cards in hand:</div>'."\n";
      echo "\n";
      echo '   <div class="cards">'."\n";
      echo "\n";
      foreach ($g['players'][$my_pid]['cards'] as $card)
      {
         echo '      <div class="card" onclick="play(\''.$card['name'].'\');">'."\n";
         echo '         <img src="'.$card['img'].'" alt="'.$card['fullname'].'" title="'.$card['fullname'].'" />'."\n";
         echo '         <div class="name">'.$card['fullname'].'</div>'."\n";
         echo '      </div>'."\n";
      }
      echo "\n";
      echo '   </div>'."\n";
      echo "\n";
      if ($can_draw)
      {
         echo '   <div class="action">'."\n";
         echo '      <a href="#draw">Draw</a>'."\n";
         echo '   </div>'."\n";
      }
      echo '</div>'."\n";


      // Opponents Section

      echo '<div class="opponents">'."\n";
      foreach ($g['players'] as $player)
      {
         if ($player['pid'] == $my_pid)
            continue;

         echo '   <div class="player">'."\n";
         echo '      <div class="hand">'."\n";
         echo "\n";
         for ($j=0; $j < count($player['cards']); $j++)
         {
            echo '         <div class="card">'."\n";
            echo '            <img src="img/back.png" alt="Back of Card" title="Back of Card" />'."\n";
            echo '            <div class="name">Back of Card</div>'."\n";
            echo '         </div>'."\n";
         }
         echo "\n";
         echo '      </div>'."\n";
         echo '      <div class="name">'."\n";
         echo '         '.$player['name']."\n";
         echo '      </div>'."\n";
         echo '   </div>'."\n";
      }
      echo '</div>'."\n";


      echo "\n";
      echo '</body>'."\n";


      // auto-play
      $oAction = mysql_("SELECT Action FROM rsk_turns WHERE GameID='$gid' AND Turn=".($turn)." LIMIT 1"); //observedAction
      if ($oAction)
      {
         echo "\n";
         echo '<script type="text/javascript">'."\n";

         if ($oAction == "Play")
            echo '   speed = '.(observe_speed*4).';'."\n";
         if ($oAction == "Take")
            echo '   speed = '.(observe_speed*2).';'."\n";
         if ($oAction == "Draw")
            echo '   speed = '.(observe_speed/2).';'."\n";

         echo '   setTimeout(\'window.location.href="?observe='.$gid.'&turn='.($turn+1).'"\', speed);'."\n";
         echo '</script>'."\n";
         echo "\n";
      }

      echo '</html>'."\n";

      exit;
   }
}

ingame:
{
   if (isset($_SESSION['user']) && mysql_("SELECT GameID FROM rsk_turns WHERE GameID=(SELECT GameID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0' LIMIT 1)", true) > 0)
   {
      $q = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0' LIMIT 1", MYSQL_ASSOC);
      $gid = $q['GameID'];
      $my_pid = $q['PID'];

      $turn = mysql_("SELECT Turn FROM rsk_turns WHERE GameID=$gid", true);

      if (!isset($_SESSION['game']) || $_SESSION['game']['gid']!=$gid || $_SESSION['game']['turn']!=$turn)
      {
         // parse game
         echo '<script type="text/javascript">window.location.href="?parse='.$gid.'&turn='.$turn.'&back=?";</script>'."\n";
         exit;
      }

      $g = &$_SESSION['game'];

      $can_play = ($g['onturn']==$my_pid);
         // true if current player is on turn
      $can_take = ($g['onturn']==$my_pid) && (count($g['sethands'])>0) && (count($g['cards']['played'])==0);
         // true if current player is: on turn, there are set cards, there are no played cards
      $can_draw = ($g['onturn']==$my_pid) && (count($g['cards']['played'])==0) && $g['rules']['turnDraw'];
         // true if current player is: on turn, there are no played cards, rule:turnDraw is enabled
      // Done with the variables


      echo '<html>'."\n";
      echo '<head>'."\n";
      echo '   <title>Risk Jack - In Game</title>'."\n";
      echo '   <script type="text/javascript" src="?js&call&poll&clean"></script>'."\n";
      echo '   <link rel="stylesheet" type="text/css" href="?css&ingame" />'."\n";
      echo '</head>'."\n";

      echo '<body>'."\n";
      echo "\n";


      if ($g['gameover'])
      {
         $_SESSION['dealt'] = true;
         echo '<script type="text/javascript">window.location.href="?finalize"</script>'."\n";
         exit;
      }


      // Deck Section

      echo '<div class="deck">'."\n";
      echo '   <div class="cards">'."\n";
      echo '      <div class="card">'."\n";
      echo '         <img src="img/back.png" alt="Back of Card" title="Back of Card" />'."\n";
      echo '         <div class="name">Back of Card</div>'."\n";
      echo '      </div>'."\n";
      echo '   </div>'."\n";
      echo "\n";
      echo '   <div class="description">'."\n";
      echo '      <span class="number">'.count($g['cards']['indeck']).'</span>'."\n";
      echo '      <div class="clarification">in deck</div>'."\n";
      echo '   </div>'."\n";
      echo '</div>'."\n";


      // Notice Section

      echo '<div class="turn notice">'."\n";
      echo '   '.($g['onturn'] == $my_pid ? "Your turn" : $g['players'][$g['onturn']]['name']."'s turn")."\n";
      echo '</div>'."\n";


      // Played Hand Section

      echo '<div class="played hand">'."\n";
      echo '   <div class="header">Played cards:</div>'."\n";
      echo "\n";
      echo '   <div class="cards">'."\n";
      echo "\n";
      foreach ($g['cards']['played'] as $card)
      {
         echo '      <div class="card">'."\n";
         echo '         <img src="'.$card['img'].'" alt="'.$card['fullname'].'" title="'.$card['fullname'].'" />'."\n";
         echo '         <div class="name">'.$card['fullname'].'</div>'."\n";
         echo '      </div>'."\n";
      }
      echo "\n";
      echo '   </div>'."\n";
      echo '</div>'."\n";


      // Set Hands Section

      echo '<div class="set hand">'."\n";
      echo '   <div class="cards">'."\n";
      echo "\n";

      $lastHand = end($g['sethands']);
      if (!$lastHand) $lastHand = array();
      foreach ($lastHand as $card)
      {
         echo '      <div class="last-hand card">'."\n";
         echo '         <img src="'.$card['img'].'" alt="'.$card['fullname'].'" title="'.$card['fullname'].'" />'."\n";
         echo '         <div class="name">'.$card['fullname'].'</div>'."\n";
         echo '      </div>'."\n";
      }

      for ($i=1; $i < count($g['sethands']); $i++)
      {
         echo '      <div class="card">'."\n";
         echo '         <img src="img/back.png" alt="Back of Card" title="Back of Card" />'."\n";
         echo '         <div class="name">Back of Card</div>'."\n";
         echo '      </div>'."\n";
      }

      echo "\n";
      echo '   </div>'."\n";
      echo "\n";
      echo '   <div class="description">'."\n";
      echo '      <span class="number">'.count($g['sethands']).'</span>'."\n";
      echo '      <div class="clarification">set hand'.(count($g['sethands'])!=1 ? "s" : "&nbsp;").'</div>'."\n";
      echo '   </div>'."\n";
      echo "\n";
      if ($can_take)
      {
         echo '   <div>'."\n";
         echo '      <a class="action" href="?takecards">Take</a>'."\n";
         echo '   </div>'."\n";
      }
      echo '</div>'."\n";


      // Current Player's Hand Section

      echo '<div class="player hand'.(($can_play&&!$can_draw) ? "" : " unavailable").'">'."\n";
      echo '   <div class="header">Cards in hand:</div>'."\n";
      echo "\n";
      echo '   <div class="cards">'."\n";
      echo "\n";
      foreach ($g['players'][$my_pid]['cards'] as $card)
      {
         echo '      <div class="card" onclick="play(\''.$card['name'].'\');">'."\n";
         echo '         <img src="'.$card['img'].'" alt="'.$card['fullname'].'" title="'.$card['fullname'].'" />'."\n";
         echo '         <div class="name">'.$card['fullname'].'</div>'."\n";
         echo '      </div>'."\n";
      }
      echo "\n";
      echo '   </div>'."\n";
      echo "\n";
      if ($can_draw)
      {
         echo '   <div>'."\n";
         echo '      <a class="action" href="?draw">Draw</a>'."\n";
         echo '   </div>'."\n";
      }
      echo '</div>'."\n";


      // Opponents Section

      echo '<div class="opponents">'."\n";
      foreach ($g['players'] as $player)
      {
         if ($player['pid'] == $my_pid)
            continue;

         echo '   <div class="player">'."\n";
         echo '      <div class="hand">'."\n";
         echo "\n";
         for ($j=0; $j < count($player['cards']); $j++)
         {
            echo '         <div class="card">'."\n";
            echo '            <img src="img/back.png" alt="Back of Card" title="Back of Card" />'."\n";
            echo '            <div class="name">Back of Card</div>'."\n";
            echo '         </div>'."\n";
         }
         echo "\n";
         echo '      </div>'."\n";
         echo '      <div class="name">'."\n";
         echo '         '.$player['name']."\n";
         echo '      </div>'."\n";
         echo '   </div>'."\n";
      }
      echo '</div>'."\n";


      echo "\n";
      echo '</body>'."\n";

      // javascript handlers

      echo "\n";
      echo '<script type="text/javascript">'."\n";
      echo 'function play (card) {'."\n";

      if ($g['onturn'] == $my_pid)
      {
         echo '   if (!card) return false;'."\n";
         echo "\n";
         echo '   window.location.href = "?play="+card;'."\n";
      }
      else
         echo '   return true;'."\n";

      echo '}'."\n";;
      echo '</script>'."\n";
      echo "\n";


      // animation
      echo '<script type="text/javascript" src="?js&loadingOverhaul"></script>'."\n";
      echo '<script type="text/javascript" src="test.php?animation"></script>'."\n";

      // polling
      $pollfor = 'game:'.$g['gid'];
      echo "\n";
      echo '<script type="text/javascript">'."\n";
      echo '   poll("'.$pollfor.'");'."\n";
      echo '</script>'."\n";
      echo "\n";

      echo '</html>'."\n";

      exit;
   }
}

pregame:
{
   if (isset($_SESSION['user']) && mysql_("SELECT * FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0'",true)>0)
   {
      $g = mysql_("SELECT p.GameID as gid, g.Name as name, g.Host as host, p.PID as my_pid, g.PlayerCount as playerCount, g.startingHand as startingHand, g.turnDraw as turnDraw, g.takeDraw as takeDraw, g.emptyDraw as emptyDraw, g.forcedAnswer as forcedAnswer, g.forcedRaise as forcedRaise FROM rsk_players as p, rsk_games as g WHERE p.GameID = g.GID AND p.Player='".$_SESSION['user']."' AND p.Finished='0' LIMIT 1", MYSQL_ASSOC);


      echo '<html>'."\n";
      echo '<head>'."\n";
      echo '   <title>Risk Jack - Pre-Game</title>'."\n";
      echo '   <script type="text/javascript" src="?js&call&poll&clean"></script>'."\n";
      echo '   <link rel="stylesheet" type="text/css" href="?css&pregame" />'."\n";
      echo '</head>'."\n";

      echo '<body>'."\n";
      echo "\n";

      echo '<div class="pre-game main">'."\n";
      echo '   <div class="name">'.$g['name'].'</div>'."\n";
      echo "\n";

      echo '   <div class="ruleset">'."\n";
      echo '      <div class="header">Rules</div>'."\n";
      echo "\n";

      presets:
      {
         $presets = array(
            "exhausting2" => array(
               "fullname" => "Exhausting 1v1",
               'playerCount' => 2,
               'startingHand' => 5,
               'forcedAnswer' => 1,
               'forcedRaise' => 0,
               'turnDraw' => 0,
               'takeDraw' => 1,
               'emptyDraw' => 2
            ),
            "curious2" => array(
               "fullname" => "Curious 1v1",
               'playerCount' => 2,
               'startingHand' => 2,
               'forcedAnswer' => 1,
               'forcedRaise' => 1,
               'turnDraw' => 0,
               'takeDraw' => 0,
               'emptyDraw' => 2
            ),
            "casual2" => array(
               "fullname" => "Casual 1v1",
               'playerCount' => 2,
               'startingHand' => 5,
               'forcedAnswer' => 0,
               'forcedRaise' => 0,
               'turnDraw' => 1,
               'takeDraw' => 0,
               'emptyDraw' => 0
            )
         );
      }

      $preset = 'custom';
      foreach ($presets as $name => $rules)
      {
         foreach ($rules as $key => $value)
         {
            if ($key == "fullname")
               continue;

            if ($g[$key] != $value)
               continue 2;
         }

         $preset = $name;
      }

      if ($_SESSION['user'] == $g['host'])
      {
         echo '      <select class="preset" onchange="selectPreset(this.value);">'."\n";
         foreach ($presets as $name => $rules)
            echo '         <option value="'.$name.'"'.($preset==$name? ' selected' : '').'>'.$rules['fullname'].'</option>'."\n";
         echo '         <option value="custom" style="display: none;"'.($preset=='custom'? ' selected' : '').'>Custom</option>'."\n";
         echo '      </select>'."\n";

         echo '      <script type="text/javascript">'."\n";
         echo '         presets = new Object();'."\n";
         foreach ($presets as $name => $rules)
         {
            echo '         presets["'.$name.'"] = {';
            $first = true;

            foreach ($rules as $key => $value)
            {
               if ($key == "fullname")
                  continue;

               echo ($first? "" : ", ").$key.": ".$value;
               $first = false;
            }

            echo '};'."\n";
         }
         echo "\n";

         echo '         function selectPreset (prst) {'."\n";
         echo '            var p = presets[prst];'."\n";

         echo '            window.location.href="?update"';
         foreach (reset($presets) as $key => $value)
            echo '+("&'.$key.'="+p.'.$key.')';
         echo ';'."\n";

         echo '         }'."\n";
         echo '      </script>'."\n";
         echo "\n";
      }
      else
      {
         echo '      <div class="preset">';
         if ($preset == 'custom')
            echo 'Custom';
         else
            echo $presets[$preset]["fullname"];
         echo '</div>'."\n";
      }

      echo '      <div class="toggler" state="0" onclick="this.setAttribute(\'state\', (this.getAttribute(\'state\')==1? \'0\' : \'1\'));"></div>'."\n";
      echo '      <div class="rules">'."\n";
      echo '         <div class="rule" id="player-count">'."\n";
      echo '            <span class="title">Player count</span>'."\n";
      echo '            <span class="value"> <b>'.$g['playerCount'].'</b> players</span>'."\n";
      echo '         </div>'."\n";
      echo '         <div class="rule" id="starting-hand">'."\n";
      echo '            <span class="title">Starting hand</span>'."\n";
      echo '            <span class="value"> <b>'.$g['startingHand'].'</b> cards</span>'."\n";
      echo '         </div>'."\n";
      echo '         <div class="rule" id="forced-answer">'."\n";
      echo '            <span class="title">Must Answer</span>'."\n";
      echo '            <span class="value">'.($g['forcedAnswer']==1 ? "Yes" : "No").'</span>'."\n";
      echo '         </div>'."\n";
      echo '         <div class="rule" id="forced-raise">'."\n";
      echo '            <span class="title">Must Raise</span>'."\n";
      echo '            <span class="value">'.($g['forcedRaise']==1 ? "Yes" : "No").'</span>'."\n";
      echo '         </div>'."\n";
      echo '         <div class="rule" id="turn-draw">'."\n";
      echo '            <span class="title">Turn Draw</span>'."\n";
      echo '            <span class="value">'.($g['turnDraw']==1 ? "Yes" : "No").'</span>'."\n";
      echo '         </div>'."\n";
      echo '         <div class="rule" id="take-draw">'."\n";
      echo '            <span class="title">Take Draw</span>'."\n";
      echo '            <span class="value">'.($g['takeDraw']==1 ? "Yes" : "No").'</span>'."\n";
      echo '         </div>'."\n";
      echo '         <div class="rule" id="empty-draw">'."\n";
      echo '            <span class="title">Empty Draw</span>'."\n";
      echo '            <span class="value"> <b>'.$g['emptyDraw'].'</b> cards</span>'."\n";
      echo '         </div>'."\n";
      echo '      </div>'."\n";

      echo '   </div>'."\n";
      echo "\n";

      $playersJoined = mysql_("SELECT 1 FROM rsk_players WHERE GameID=".$g['gid']." AND Finished=0", true);

      echo '   <div class="players">'."\n";
      echo '      <div class="header">Players</div>'."\n";
      echo '      <span class="joined">'.$playersJoined.'</span>'."\n";
      echo '       /'."\n";
      echo '      <span class="maximum">'.$g['playerCount'].'</span>'."\n";
      echo "\n";

      echo '      <div class="slots">'."\n";
      for ($i=0; $i < $g['playerCount']; $i++)
      {
         $slot = mysql_("SELECT Player FROM rsk_players WHERE GameID=".$g['gid']." AND PID=".($i+1)."");
         if ($slot == false)
         {
            echo '         <div class="empty slot">'."\n";
            echo '            Empty slot'."\n";
            echo '         </div>'."\n";
         }
         else
         {
            echo '         <div class="slot">'."\n";
            echo '            <span class="position" name="movable">'.($i+1).'</span>'."\n";
            echo '            <span class="player-name">'.$slot.'</span>'."\n";

            if ($_SESSION['user'] == $g['host'] && $slot != $g['host'])
            {
               echo '            <a href="?kick='.$slot.'" class="option kick" title="Kick player"> Kick </a>'."\n";
               echo '            <a href="?promote='.$slot.'" class="option promote" title="Promote to Host"> Promote </a>'."\n";
            }

            echo '         </div>'."\n";
         }
      }
      echo '      </div>'."\n";
      echo "\n";

      if ($_SESSION['user'] == $g['host'])
      {
         echo '      <script type="text/javascript" src="?js&movables"></script>'."\n";
         echo "\n";
      }

      echo '   </div>'."\n";
      echo "\n";

      echo '   <div class="actions">'."\n";

      if ($_SESSION['user'] == $g['host'])
         echo '      <button onclick="window.location.href=\'?startgame\';">Start Game</button>'."\n";
      echo '      <button onclick="window.location.href=\'?leavegame\';">Leave Game</button>'."\n";

      echo '   </div>'."\n";
      echo "\n";

      echo '</div>'."\n";

      echo "\n";
      echo '</body>'."\n";

      // polling
      $pollfor = 'game:'.$g['gid'];
      echo "\n";
      echo '<script type="text/javascript">'."\n";
      echo '   poll("'.$pollfor.'");'."\n";
      echo '</script>'."\n";
      echo "\n";

      echo '</html>'."\n";

      exit;
   }
}

lobby:
{
   if (isset($_SESSION['user']))
   {
      echo '<html>'."\n";
      echo '<head>'."\n";
      echo '   <title>Risk Jack - Lobby</title>'."\n";
      echo '   <link rel="stylesheet" type="text/css" href="?css&lobby" />'."\n";
      echo '   <script type="text/javascript" src="?js&call&poll&clean"></script>'."\n";
      echo '</head>'."\n";
      echo '<body onunload="call(\'?test\');">'."\n";
      echo "\n";
      echo '<div>'."\n";
      echo '   Welcome, '.$_SESSION['user']."\n";
      echo '   <br /> <a href="?logout">Logout</a>'."\n";
      echo '</div>'."\n";
      echo "\n";
      echo '<div class="lobby main">'."\n";
      echo "\n";
      echo '   <div> <button onclick="window.location.href=\'?newgame\';"> Create Game </button> </div>'."\n";
      echo "\n";
      echo '   <script type="text/javascript">'."\n";
      echo '      function filterGames (category, keyword) {'."\n";
      echo '         var cnt = document.getElementById("cnt:games-"+category);'."\n";
      echo "\n";
      echo '         var i;'."\n";
      echo '         for (i=0; i < cnt.childNodes.length; i++) {'."\n";
      echo '            if (cnt.childNodes[i].className && cnt.childNodes[i].className.indexOf("game") == -1)'."\n";
      echo '               continue;'."\n";
      echo "\n";
      echo '            var j;'."\n";
      echo '            for (j=0; j < cnt.childNodes[i].childNodes.length; j++) {'."\n";
      echo '               if (cnt.childNodes[i].childNodes[j].className && cnt.childNodes[i].childNodes[j].className.indexOf("name") == -1)'."\n";
      echo '                  continue;'."\n";
      echo "\n";
      echo '               if (cnt.childNodes[i].childNodes[j].innerHTML)'."\n";
      echo '               {'."\n";
      echo '                  if (cnt.childNodes[i].childNodes[j].innerHTML.indexOf(keyword) == -1)'."\n";
      echo '                     cnt.childNodes[i].className += " hidden";'."\n";
      echo '                  else'."\n";
      echo '                     cnt.childNodes[i].className = cnt.childNodes[i].className.replace(/( |^)hidden( |$)/gi, "");'."\n";
      echo '               }'."\n";
      echo '            }'."\n";
      echo '         }'."\n";
      echo '      }'."\n";
      echo '   </script>'."\n";
      echo "\n";

      $games  = mysql_("SELECT * FROM rsk_games ORDER BY GID ASC", MYSQL_ASSOC|MYSQL_TABLE);
      if (!is_array($games)) $games = array();
      $games_played = array();

      echo '   <div class="available games" id="cnt:games-avail">'."\n";
      echo '      <div class="header">Available Games</div>'."\n";
      echo '      <div class="filter"> <input type="text" id="fltr:games-avail" onkeyup="filterGames(\'avail\', this.value);" /></div>'."\n";
      echo '      <div class="when-empty"> No games found </div>'."\n";
      echo "\n";
      foreach ($games as $game)
      {
         if (!is_array($game)) continue;

         $game['Turns'] = mysql_("SELECT * FROM rsk_turns WHERE GameID='".$game['GID']."'", true);
         if ($game['Turns'] > 0)
         {
            $games_played[] = $game;
            continue;
         }

         $game['PlayersJoined'] = mysql_("SELECT GameID FROM rsk_players WHERE GameID='".$game['GID']."'", true);

         echo '      <div class="game" onclick="window.location.href=\'?join='.$game['GID'].'\';">'."\n";
         echo '         <div class="name">'.$game['Name'].'</div>'."\n";
         echo '         <div class="players">'."\n";
         echo '            <span class="joined">'.$game['PlayersJoined'].'</span>'."\n";
         echo '            /'."\n";
         echo '            <span class="maximum">'.$game['PlayerCount'].'</a>'."\n";
         echo '         </div>'."\n";
         echo '         <div class="rules">'."\n";
         echo '            <span class="starting-hand">'.$game['startingHand'].'</span>'."\n";
         echo '            <span class="empty-draw">'.$game['emptyDraw'].'</span>'."\n";
         echo '            <span class="forced-answer">'.($game['forcedAnswer']==1? "yes" : "no").'</span>'."\n";
         echo '            <span class="forced-raise">'.($game['forcedRaise']==1? "yes" : "no").'</span>'."\n";
         echo '            <span class="turn-draw">'.($game['turnDraw']==1? "yes" : "no").'</span>'."\n";
         echo '         </div>'."\n";
         echo '      </div>'."\n";
      }
      echo '   </div>'."\n";
      echo "\n";

      echo '   <div class="played games" id="cnt:games-played">'."\n";
      echo '      <div class="header">Played Games</div>'."\n";
      echo '      <div class="filter"> <input type="text" id="fltr:games-played" onkeyup="filterGames(\'played\', this.value);" /></div>'."\n";
      echo '      <div class="when-empty"> No games found </div>'."\n";
      echo "\n";
      foreach ($games_played as $game)
      {
         if (!is_array($game)) continue;

         echo '      <div class="game" onclick="window.location.href=\'?observe='.$game['GID'].'\';">'."\n";
         echo '         <div class="name">'.$game['Name'].'</div>'."\n";
         echo '         <div class="players">'."\n";
         echo '            <span class="maximum">'.$game['PlayerCount'].'</a>'."\n";
         echo '         </div>'."\n";
         echo '         <div class="rules">'."\n";
         echo '            <span class="starting-hand">'.$game['startingHand'].'</span>'."\n";
         echo '            <span class="empty-draw">'.$game['emptyDraw'].'</span>'."\n";
         echo '            <span class="forced-answer">'.($game['forcedAnswer']==1? "yes" : "no").'</span>'."\n";
         echo '            <span class="forced-raise">'.($game['forcedRaise']==1? "yes" : "no").'</span>'."\n";
         echo '            <span class="turn-draw">'.($game['turnDraw']==1? "yes" : "no").'</span>'."\n";
         echo '         </div>'."\n";
         echo '      </div>'."\n";
      }
      echo '   </div>'."\n";
      echo "\n";

      echo '</div>'."\n";
      echo "\n";
      echo '</body>'."\n";

      // polling
      $pollfor = 'lobby';
      echo "\n";
      echo '<script type="text/javascript">'."\n";
      echo '   poll("'.$pollfor.'");'."\n";
      echo '</script>'."\n";
      echo "\n";

      echo '</html>'."\n";
   }
}

login:
{
   if (isset($_SESSION['user']))
      exit;

   echo '<html>'."\n";
   echo '<head>'."\n";
   echo '   <title>Risk Jack - Login</title>'."\n";
   echo '   <link rel="stylesheet" type="text/css" href="?css&login" />'."\n";
   echo '   <script type="text/javascript" src="?js&call"></script>'."\n";
   echo '</head>'."\n";
   echo '<body>'."\n";
   echo "\n";
   echo '<div class="login main">'."\n";
   echo '   <div class="stage" id="s1">'."\n";
   echo '      <label>'."\n";
   echo '         Username:<br />'."\n";
   echo '         <input type="text" id="inp:user" placeholder="Username" tabindex=1 />'."\n";
   echo '      </label>'."\n";
   echo '      <script type="text/javascript">'."\n";
   echo '         inp_usr = document.getElementById("inp:user");'."\n";
   echo '         cur_stg = false;'."\n";
   echo "\n";
   echo '         inp_usr.onkeydown = function (event) {'."\n";
   echo '            if (event.keyCode == 9) //The Tab key'."\n";
   echo '            {'."\n";
   echo '               setTimeout(inp_usr.onchange, 0);'."\n";
   echo '               return false;'."\n";
   echo '            }'."\n";
   echo '         }'."\n";
   echo "\n";
   echo '         inp_usr.onchange = function () {'."\n";
   echo '            var r = call("?login&s1&check="+this.value, true);'."\n";
   echo "\n";
   echo '            if (r != "s2" && r != "s3")'."\n";
   echo '               return false;'."\n";
   echo "\n";
   echo '            if (cur_stg)'."\n";
   echo '               cur_stg.className = cur_stg.className.replace(/( |^)active( |$)/gi, "");'."\n";
   echo "\n";
   echo '            cur_stg = document.getElementById(r);'."\n";
   echo '            cur_stg.className += " active";'."\n";
   echo "\n";
   echo '            document.getElementById("inp:"+r+"-user").value = this.value;'."\n";
   echo '            document.getElementById("inp:"+r+"-pwd").focus();'."\n";
   echo '         }'."\n";
   echo "\n";
   if (isset($_COOKIE['remember']))
   {
      echo '         inp_usr.value = "'.$_COOKIE['remember'].'";'."\n";
      echo '         window.onload = function () {inp_usr.onchange();}'."\n";
   }
   echo '         document.getElementById("inp:remusr").onchange = function () {'."\n";
   echo '            document.getElementById("inp:s2-remusr").value = this.value;'."\n";
   echo '         }'."\n";
   echo '      </script>'."\n";
   echo '   </div>'."\n";
   echo '   <div class="stage" id="s2">'."\n";
   echo '      <form action="?login&s2" method="POST">'."\n";
   echo '         <input type="hidden" name="username" id="inp:s2-user" value="" />'."\n";
   echo '         <label for="inp:s2-pwd">'."\n";
   echo "\n";
   echo '               <input type="checkbox" name="remusr" class="remember" title="Remember username"'.(isset($_COOKIE['remember'])? ' checked' : '').' tabindex=4 style="position: relative; top: -5.7em;" />'."\n";
   echo '               <input type="checkbox" name="stayin" class="remember" title="Stay logged in" tabindex=5 />'."\n";
   echo "\n";
   echo '            Password:<br />'."\n";
   echo '            <input type="password" name="password" id="inp:s2-pwd" placeholder="Password" tabindex=2 />'."\n";
   echo '         </label>'."\n";
   echo '         <label>'."\n";
   echo '            <input type="submit" value="Send" />'."\n";
   echo '         </label>'."\n";
   echo '      </form>'."\n";
   echo '   </div>'."\n";
   echo '   <div class="stage" id="s3">'."\n";
   echo '      <form action="?login&s3" method="POST" onsubmit="return (checkPasswords() && cnfSubmition());">'."\n";
   echo '         <div class="header">Register</div>'."\n";
   echo '         <input type="hidden" name="username" id="inp:s3-user" value="" />'."\n";
   echo '         <label>'."\n";
   echo '            Password:<br />'."\n";
   echo '            <input type="password" name="password" id="inp:s3-pwd" placeholder="Password" tabindex=2 />'."\n";
   echo '         </label>'."\n";
   echo '         <label>'."\n";
   echo '            Confirm Password:<br />'."\n";
   echo '            <input type="password" id="inp:s3-cnf" placeholder="Retype Password" tabindex=3 />'."\n";
   echo '         </label>'."\n";
   echo '         <label>'."\n";
   echo '            <input type="submit" value="Send" />'."\n";
   echo '         </label>'."\n";
   echo '      </form>'."\n";
   echo '      <script type="text/javascript">'."\n";
   echo '         function checkPasswords () {'."\n";
   echo '            var p1 = document.getElementById("inp:s3-pwd");'."\n";
   echo '            var p2 = document.getElementById("inp:s3-cnf");'."\n";
   echo "\n";
   echo '            p1.className = p1.className.replace(/( |^)wrong( |$)/gi, "");'."\n";
   echo '            p2.className = p2.className.replace(/( |^)wrong( |$)/gi, "");'."\n";
   echo "\n";
   echo '            if (p1.value != p2.value)'."\n";
   echo '            {'."\n";
   echo '               if (p1.value != "" && p2.value != "")'."\n";
   echo '               {'."\n";
   echo '                  p1.className += " wrong";'."\n";
   echo '                  p2.className += " wrong";'."\n";
   echo '               }'."\n";
   echo "\n";
   echo '               return false;'."\n";
   echo '            }'."\n";
   echo "\n";
   echo '            return true;'."\n";
   echo '         }'."\n";
   echo "\n";
   echo '         document.getElementById("inp:s3-pwd").onchange = checkPasswords;'."\n";
   echo '         document.getElementById("inp:s3-cnf").onchange = checkPasswords;'."\n";
   echo "\n";
   echo '         function cnfSubmition () {'."\n";
   echo '            return confirm("Are you sure you want to register under this nickname?");'."\n";
   echo '         }'."\n";
   echo '      </script>'."\n";
   echo '   </div>'."\n";
   if (isset($_REQUEST['fail']))
   {
      echo '   <div class="stage active" id="s4">'."\n";
      echo '      <label>'."\n";
      echo '         <div class="error">Invalid Username or Password</div>'."\n";
      echo '      </label>'."\n";
      echo '   </div>'."\n";
      echo '   <script type="text/javascript">cur_stg = document.getElementById("s4");</script>'."\n";
   }
   echo '</div>'."\n";
   echo "\n";
   echo '</body>'."\n";
   echo '</html>'."\n";
}

?>