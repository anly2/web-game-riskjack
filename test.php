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