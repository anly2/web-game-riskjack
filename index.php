<?php
session_start();
include_once "mysql.php";
mysql_("");

variables:
{
   define('status_margin', 1000, true);
   define('em', 16, true);
   define('cardsPerDeal', 3, true);
}

login_check:
{
   if (mysql_("SELECT Username FROM rsk_users WHERE SID='".session_id()."'", true) > 0)
      $_SESSION['user'] = mysql_("SELECT Username FROM rsk_users WHERE SID='".session_id()."'");
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

         echo 'function poll (pollfor, state) {'."\n";
         echo '   if (!pollfor) return false;'."\n";
         echo "\n";
         echo '   call("?poll="+pollfor+(!state? "" : "&state="+state),'."\n";
         echo '      function(t){'."\n";
         echo '         if(t=="1")'."\n";
         echo '            window.location.href="?";'."\n";
         echo '         else'."\n";
         echo '            poll(pollfor, state);'."\n";
         echo '      }'."\n";
         echo '   );'."\n";
         echo '}'."\n";
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

      mysql_query("UPDATE rsk_users SET SID='".session_id()."' WHERE Username='$usr' AND Password='$pwd'") or die(mysql_error());

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
      mysql_("UPDATE rsk_users SET SID=NULL WHERE Username='".$_SESSION['user']."'");
      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
}

if (!isset($_SESSION['user']) && count($_REQUEST) > 0)
{
   echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
   exit;
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
         $gs = mysql_("SELECT GID FROM rsk_games ORDER BY GID ASC", MYSQL_ASSOC);
         foreach ($gs as $k=>$v)
            if ($k+1 != $v['GID'])
            {
               $gid = $k+1;
               break;
            }
      }

      $name = mysql_real_escape_string($_SESSION['user'] . "'s game");

      mysql_("INSERT INTO rsk_games (GID, Name) VALUES ('$gid', '$name')") or die(mysql_error());
      mysql_("INSERT INTO rsk_players (Player, GameID, PID) VALUES ('".$_SESSION['user']."', '$gid', 1)") or die(mysql_error());

      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1, ".status_margin.") WHERE `Key`='lobby'");
      mysql_("INSERT INTO rsk_status (`Key`, `Value`) VALUES ('game:$gid', 0)");

      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['join']))
   {
      $gid = intval($_REQUEST['join']);

      $slots  = intval(mysql_("SELECT PlayerCount FROM rsk_games WHERE GID='$gid'"));
      $joined = mysql_("SELECT GameID FROM rsk_players WHERE GameID='$gid'", true);

      if ($slots > $joined)
      {
         $q = mysql_("SELECT PID FROM rsk_players WHERE GameID='$gid' ORDER BY PID DESC LIMIT 1", MYSQL_ASSOC);
         $pid = intval($q['PID'])+1;

         mysql_("INSERT INTO rsk_players (Player, GameID, PID) VALUES ('".$_SESSION['user']."', '$gid', '$pid')") or die(mysql_error());

         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:$gid'");
      }

      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['update']))
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0' LIMIT 1", MYSQL_ASSOC);
      if ($g['PID'] != 1)
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
         mysql_("UPDATE rsk_games SET $setstring WHERE GID='".$g['GameID']."'");
         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['GameID']."'");
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

         mysql_("UPDATE rsk_players SET PID=0 WHERE GameID='".$g['GameID']."' AND PID = ".$pid) or die(mysql_error());

         if ($chg < 0)
            mysql_("UPDATE rsk_players SET PID=PID+1 WHERE GameID='".$g['GameID']."' AND PID >= ".($pid+$chg)." AND PID < ".$pid);
         else
            mysql_("UPDATE rsk_players SET PID=PID-1 WHERE GameID='".$g['GameID']."' AND PID > ".$pid." AND PID <= ".($pid+$chg));

         mysql_("UPDATE rsk_players SET PID=".($pid+$chg)." WHERE GameID='".$g['GameID']."' AND PID = 0");
         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['GameID']."'");
      }

      echo '<script type="text/javascript">window.location.href="?";</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['leavegame']))
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0' LIMIT 1", MYSQL_ASSOC);
      mysql_("DELETE FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0'");
      mysql_("UPDATE rsk_players SET PID=PID-1 WHERE GameID='".$g['GameID']."' AND PID>".$g['PID']);

      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['GameID']."'");

      $c = mysql_("SELECT GameID FROM rsk_players WHERE GameID='".$g['GameID']."'", true);
      if ($c == 0)
      {
         mysql_("DELETE FROM rsk_games WHERE GID='".$g['GameID']."'");

         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='lobby'");
         mysql_("DELETE FROM rsk_status WHERE `Key`='game:".$g['GameID']."'");
      }

      echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['startgame']))
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0' LIMIT 1", MYSQL_ASSOC);

      $playerCount = mysql_("SELECT PlayerCount FROM rsk_games WHERE GID='".$g['GameID']."' LIMIT 1");
      $playersIn = mysql_("SELECT GameID FROM rsk_players WHERE GameID='".$g['GameID']."' AND Finished='0'", true);

      if ($playerCount != $playersIn)
      {
         echo "Not enough players<br />\n";
         echo '<a href="?">Back</a>'."\n";
         echo '<script type="text/javascript"> setTimeout(\'window.location.href="?";\', 3000); </script>'."\n";
         exit;
      }

      if ($g['PID'] == '1')
      {
         //Prepare Deck
         $allcards = mysql_("SELECT Card FROM rsk_cards", MYSQL_NUM);

         //    array_reduce
         foreach ($allcards as $k=>$v)
            $allcards[$k] = $v[0];

         //    suffle deck
         shuffle($allcards);

         //    apply deck
         foreach ($allcards as $p=>$c)
            mysql_("INSERT INTO rsk_decks (GameID, Position, Card) VALUES (".$g['GameID'].", $p, '$c')");


         //Deal Starting Hand
         $details = mysql_("SELECT PlayerCount, startingHand FROM rsk_games WHERE GID='".$g['GameID']."' LIMIT 1", MYSQL_ASSOC);

         $dealt = 0;
         $p = 0;

         while ($dealt < $details['startingHand'] * $details['PlayerCount'])
         {
            $pc = mysql_("SELECT Player FROM rsk_turns WHERE GameID='".$g['GameID']."' AND Player='".($p+1)."'", true);

            for ($j=0; $j < cardsPerDeal; $j++)
            {
               if ($pc + $j >= $details['startingHand'])
                  break;

               $card = mysql_("SELECT Card FROM rsk_decks WHERE GameID='".$g['GameID']."' AND Position=".$dealt);
               $g['Turn'] = mysql_("SELECT MAX(Turn) FROM rsk_turns WHERE GameID='".$g['GameID']."'");
               mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['GameID']."', ".($g['Turn']+1).", ".($p+1).", 'Draw', '".$card."')") or die(mysql_error());

               $dealt++;
            }

            $p = (++$p) % $details['PlayerCount'];
         }

         // Status update
         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='lobby'");
         mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['GameID']."'");
      }

      echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }


   if (isset($_REQUEST['checkhand']))
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0' LIMIT 1", MYSQL_ASSOC);
      $gid = $g['GameID'];
      $my_pid = $g['PID'];

      // if the hands of all players are empty
      //    if rule:emptyDraw is 0
      //       ?takecards
      //    else
      //       - set $_SESSION['deal'] = rule:emptyDraw
      //       ?deal

      $players = array();
      $q = mysql_("SELECT Player, PID FROM rsk_players WHERE GameID='$gid' AND Finished='0'", MYSQL_ASSOC|MYSQL_TABLE);
      foreach ($q as $p)
         $players[$p['PID']] = array("name"=>$p['Player'], "cards"=>0);

      $q = mysql_("SELECT Action, Player FROM rsk_turns WHERE GameID='$gid' AND (Action='Draw' OR Action='Play')", MYSQL_ASSOC|MYSQL_TABLE);
      foreach ($q as $v)
      {
         if ($v['Action'] == "Draw")
            $players[$v['Player']]['cards'] ++;

         if ($v['Action'] == "Play")
            $players[$v['Player']]['cards'] --;
      }

      if (isset($_SESSION['playcard']))
         $players[$my_pid]['cards']--;

      $s = 0;
      foreach ($players as $p)
         $s += $p['cards'];

      if ($s == 0)
      {
         $rule_emptyDraw = mysql_("SELECT emptyDraw FROM rsk_games WHERE GID='$gid' LIMIT 1");

         if ($rule_emptyDraw === 0)
         {
            echo '<a href="?takecards">Onwards</a>';//echo '<script type="text/javascript"> window.location.href="?takecards"; </script>'."\n";
            exit;
         }
         else
         {
            $_SESSION['deal'] = $rule_emptyDraw;
            echo '<a href="?deal='.$_SESSION['deal'].'">Onwards</a>';//echo '<script type="text/javascript"> window.location.href="?deal"; </script>'."\n";
            exit;
         }
      }


      // see rule:turnDraw
      //    if enabled check if players have startingHand cards in their hands
      //       if they don't have enough cards ?deal 1

      $rule_turnDraw = mysql_("SELECT turnDraw FROM rsk_games WHERE GID='$gid' LIMIT 1");
      if ($rule_turnDraw)
      {
         $rule_startingHand = mysql_("SELECT startingHand FROM rsk_games WHERE GID='$gid' LIMIT 1");

         if ($s % count($players) == 0 && $s/count($players) < $rule_startingHand)
         {
            $_SESSION['deal'] = 1;
            echo '<a href="?deal='.$_SESSION['deal'].'">Onwards</a>';//echo '<script type="text/javascript"> window.location.href="?deal"; </script>'."\n";
            exit;
         }
      }

      // return to ?play
      //    if $_SESSION['playcard'] is set
      //       - set $_SESSION['checkedHand']
      //       ?play=$_SESSION['playcard']

      if (isset($_SESSION['playcard']))
      {
         $playcard = $_SESSION['playcard'];
         unset($_SESSION['playcard']);

         $_SESSION['checkedHand'] = true;
         echo '<a href="?play='.$playcard.'">Onwards</a>';//echo '<script type="text/javascript"> window.location.href="?play='.$playcard.'"; </script>'."\n";
         exit;
      }

      echo '<a href="?">Onwards</a>';//echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['play']))
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1", MYSQL_ASSOC);

      $card = mysql_real_escape_string($_REQUEST['play']);
      if (mysql_("SELECT Card FROM rsk_cards WHERE Card='$card' LIMIT 1", true) == 0)
      {
         echo "No such card!";
         exit;
      }

      // check if this is a direct call
      //    if $_SESSION['checkedHand'] is not set
      //       - set $_SESSION['playcard'] = ?play=
      //       ?checkhand

      if (!isset($_SESSION['checkedHand']))
      {
         $_SESSION['playcard'] = $_REQUEST['play'];
         echo '<script type="text/javascript"> window.location.href="?checkhand"; </script>'."\n";
         exit;
      }else
         unset($_SESSION['checkedHand']);

      // check if its player's turn
      // check if the player actually has this card
      // check if is allowed to play the card
      //    see rule:forcedAnswer
      //    see rule:forcedRaise

      ////


      // play the card
      $g['Turn'] = mysql_("SELECT MAX(Turn) FROM rsk_turns WHERE GameID='".$g['GameID']."'");
      mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['GameID']."', ".($g['Turn']+1).", '".$g['PID']."', 'Play', '$card')");

      // status update
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['GameID']."'");

      echo '<a href="?">Onwards</a>';//echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['takecards']))
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1", MYSQL_ASSOC);

      // check if it is player's turn
      // check if the player won the last hand

      // take set cards
      $g['Turn'] = mysql_("SELECT MAX(Turn) FROM rsk_turns WHERE GameID='".$g['GameID']."'");
      mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['GameID']."', ".($g['Turn']+1).", '".$g['PID']."', 'Take', NULL)");

      // status update
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['GameID']."'");

      // see rule:takeDraw
      //    if enabled
      //       - set $_SESSION['deal'] = ?deal=
      //       ?deal

      $rule_takeDraw = mysql_("SELECT takeDraw FROM rsk_games WHERE GID='".$g['GameID']."' LIMIT 1");
      if ($rule_takeDraw)
      {
            $prevTake = min(0, mysql_("SELECT Turn FROM rsk_turns WHERE GameID='".$g['GameID']."' AND Action='Take' ORDER BY Turn DESC LIMIT 1, 2"));
         $cards = mysql_("SELECT Action FROM rsk_turns WHERE GameID='".$g['GameID']."' AND Action='Play' AND Turn < ".($g['Turn']+1)." AND Turn > $prevTake", true);
         $playerCount = mysql_("SELECT GameID FROM rsk_players WHERE GameID='".$g['GameID']."' AND Finished=0", true);
         $hands = max(1, floor($cards/$playerCount));

         $_SESSION['deal'] = $hands - 1;
         echo '<a href="?deal='.$_SESSION['deal'].'">Onwards</a>';//echo '<script type="text/javascript">window.location.href="?deal"</script>'."\n";
         exit;
      }

      // ?checkhand

      echo '<a href="?checkhand">Onwards</a>';//echo '<script type="text/javascript">window.location.href="?checkhand"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['deal']))
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1", MYSQL_ASSOC);
      $gid = $g['GameID'];

      // check if this is a direct call
      //    if $_SESSION['deal'] is not set die

      if (!isset($_SESSION['deal']))
      {
         echo '<a href="?">Onwards</a>';//echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
         exit;
      }
      else
      {
         $deal = $_SESSION['deal'];
         unset($_SESSION['deal']);
      }

      // if no cards left to deal
      //    - set $_SESSION['dealt']
      //    ?finalize


         $allcards = mysql_("SELECT COUNT(GameID) FROM rsk_decks WHERE GameID='$gid'");
         $drawncards = mysql_("SELECT COUNT(GameID) FROM rsk_turns WHERE GameID='$gid' AND Action='Draw'");
      $cards_inDeck = $allcards - $drawncards; //number of left cards in deck

      if ($cards_inDeck == 0)
      {
         $_SESSION['dealt'] = true;
         echo '<a href="?finalize">Onwards</a>';//echo '<script type="text/javascript">window.location.href="?finalize"</script>'."\n";
         exit;
      }

      // check if there are enough cards in the deck
      //    if $_SESSION['deal'] * playerCount > cardsLeft
      //       divide equally


         $playerCount = mysql_("SELECT GameID FROM rsk_players WHERE GameID='$gid' AND Finished='0'", true);
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

         while ($dealt < $deal * $playerCount)
         {
            for ($j=0; $j < cardsPerDeal; $j++)
            {
               if ($pc[$p+1] + $j > $deal)
                  break;

               $card = mysql_("SELECT Card FROM rsk_decks WHERE GameID='".$g['GameID']."' AND Position=".($drawncards + $dealt));
               $g['Turn'] = mysql_("SELECT MAX(Turn) FROM rsk_turns WHERE GameID='".$g['GameID']."'");
               mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['GameID']."', ".($g['Turn']+1).", ".($p+1).", 'Draw', '".$card."')") or die(mysql_error());

               $dealt++;
               $pc[$p+1]++;
               //$drawncards++; //messes with Position=".($drawbcards + $dealt)."
               $cards_inDeck--;
            }

            $p = (++$p) % $playerCount;
         }


      // status update
      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='game:".$g['GameID']."'");

      // check for left-over cards
      //    if cardsLeft < playerCount
      //       remove last n cards from play

      if ($cards_inDeck < $playerCount)
      {
         for ($i=0; $i < $cards_inDeck; $i++)
         {
            $card = mysql_("SELECT Card FROM rsk_decks WHERE GameID='".$g['GameID']."' AND Position=".($allcards - ($cards_inDeck - $i)));
            $g['Turn'] = mysql_("SELECT MAX(Turn) FROM rsk_turns WHERE GameID='".$g['GameID']."'");
            mysql_("INSERT INTO rsk_turns (GameID, Turn, Player, Action, Card) VALUES ('".$g['GameID']."', ".($g['Turn']+1).", -1, 'Draw', '".$card."')") or die(mysql_error()); // Player=-1 basically removes the card from play
            //$cards_inDeck--; //might mess with the for-loop
         }
      }

      echo '<a href="?">Onwards</a>';//echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }
   if (isset($_REQUEST['finalize']))
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished=0 LIMIT 1", MYSQL_ASSOC);

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



      // clean rsk_decks

      mysql_("DELETE FROM rsk_decks WHERE GameID='".$g['GameID']."'");


      // set finished flags in rsk_players

      mysql_("UPDATE rsk_players SET Finished=1 WHERE GameID='".$g['GameID']."' AND Finished=0");


      // update status for lobby
      // remove status entry game:$gid

      mysql_("UPDATE rsk_status SET `Value`=MOD(`Value`+1,  ".status_margin.") WHERE `Key`='lobby'");
      mysql_("DELETE FROM rsk_status WHERE `Key`='game:".$g['GameID']."'");


      echo '<a href="?">Onwards</a>';//echo '<script type="text/javascript">window.location.href="?"</script>'."\n";
      exit;
   }
}

ingame:
{
   if (isset($_SESSION['user']) && mysql_("SELECT GameID FROM rsk_turns WHERE GameID=(SELECT GameID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0' LIMIT 1)", true) > 0)
   {
      $g = mysql_("SELECT GameID, PID FROM rsk_players WHERE Player='".$_SESSION['user']."' AND Finished='0' LIMIT 1", MYSQL_ASSOC);
      $gid = $g['GameID'];
      $my_pid = $g['PID'];


      // Fill variables
         $allcards = mysql_("SELECT COUNT(GameID) FROM rsk_decks WHERE GameID='$gid'");
         $drawncards = mysql_("SELECT COUNT(GameID) FROM rsk_turns WHERE GameID='$gid' AND Action='Draw'");
      $cards_inDeck = $allcards - $drawncards; //number of left cards in deck

      $opponents = array(); //array( array("name"=>"zemuru", "cards"=>3) );
         $players = mysql_("SELECT Player, PID FROM rsk_players WHERE GameID='$gid' AND Finished='0'", MYSQL_ASSOC|MYSQL_TABLE);
         foreach ($players as $p)
            if ($p['PID'] != $my_pid)
               $opponents[$p['PID']] = array("name"=>$p['Player'], "cards"=>0);

         $playerCount = mysql_("SELECT GameID FROM rsk_players WHERE GameID='$gid'", true);

      $player_onTurn = 1; //pid of player currently on turn
      $cards_played = array(); //array( array("name"=>"9c", "img"=>"img/9c.png", "fullname"=>"Nine of Clubs") );
      $cards_inHand = array(); //array( array("name"=>"9c", "img"=>"img/9c.png", "fullname"=>"Nine of Clubs") );
      $cards_lastHand = array();
      $cards_setHands = 0; //number of hands set

         $turns = mysql_("SELECT Player, Action, Card FROM rsk_turns WHERE GameID='$gid' ORDER BY Turn ASC", MYSQL_ASSOC|MYSQL_TABLE);

         $d = 0; //to-draw index

         foreach ($turns as $t)
         {
            if ($t['Action'] == "Draw")
            {
               if ($t['Player'] == $my_pid)
                  $cards_inHand[] = mysql_("SELECT c.Card as name, c.Img as img, c.Fullname as fullname FROM rsk_cards as c, rsk_decks as d WHERE c.Card = d.Card AND d.Position = $d LIMIT 1", MYSQL_ASSOC);
               else
                  $opponents[$t['Player']]['cards'] ++;

               $d++;
            }

            if ($t['Action'] == "Play")
            {
               //if ($player_onTurn != $t['Player'])
               //   continue;
               //   //ERROR

                  $l = count($cards_played);
               $cards_played[$l] = mysql_("SELECT Card as name, Power as power, Img as img, Fullname as fullname FROM rsk_cards WHERE Card = '".$t['Card']."' LIMIT 1", MYSQL_ASSOC);
               $cards_played[$l]["owner"] = $t['Player'];
               $player_onTurn = (($player_onTurn)%$playerCount) +1; //increment pid

               if (count($cards_played) >= $playerCount)
               {
                  //Determine winner of hand
                  unset($lead);
                  foreach ($cards_played as $k=>$card)
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
                  $player_onTurn = $lead['owner'];

                  $cards_setHands++;
                  $cards_lastHand = $cards_played;
                  $cards_played = array();
               }

               if ($t['Player'] == $my_pid)
               {
                  foreach ($cards_inHand as $k=>$v)
                     if ($v['name'] == $t['Card'])
                        unset($cards_inHand[$k]);
               }
               else
                  $opponents[$t['Player']]['cards']--;
            }

            if ($t['Action'] == "Take")
            {
               $cards_lastHand = array();
               $cards_setHands = 0;
            }
         }

      $player_onTurn_name = mysql_("SELECT Player FROM rsk_players WHERE GameID='$gid' AND PID=$player_onTurn"); //name of player currently on turn


         $q = mysql_("SELECT turnDraw FROM rsk_games WHERE GID='$gid'", MYSQL_ASSOC);
         $rule_turnDraw = $q==1;

      $can_take = ($player_onTurn==$my_pid) && ($cards_setHands>0) && (count($cards_played)==0);
         // true if current player is: on turn, there are set cards, there are no played cards
      $can_draw = ($player_onTurn==$my_pid) && (count($cards_played)==0) && $rule_turnDraw;
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
      echo '      <span class="number">'.$cards_inDeck.'</span>'."\n";
      echo '      <div class="clarification">in deck</div>'."\n";
      echo '   </div>'."\n";
      echo '</div>'."\n";


      // Notice Section

      echo '<div class="turn notice">'."\n";
      echo '   '.($player_onTurn == $my_pid ? "Your turn" : $player_onTurn_name."'s turn")."\n";
      echo '</div>'."\n";


      // Played Hand Section

      echo '<div class="played hand">'."\n";
      echo '   <div class="header">Played cards:</div>'."\n";
      echo "\n";
      echo '   <div class="cards">'."\n";
      echo "\n";
      foreach ($cards_played as $card)
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
      foreach ($cards_lastHand as $card)
      {
         echo '      <div class="last-hand card">'."\n";
         echo '         <img src="'.$card['img'].'" alt="'.$card['fullname'].'" title="'.$card['fullname'].'" />'."\n";
         echo '         <div class="name">'.$card['fullname'].'</div>'."\n";
         echo '      </div>'."\n";
      }

      for ($i=1; $i < $cards_setHands; $i++)
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
      echo '      <span class="number">'.$cards_setHands.'</span>'."\n";
      echo '      <div class="clarification">set hand'.($cards_setHands!=1 ? "s" : "&nbsp;").'</div>'."\n";
      echo '   </div>'."\n";
      echo "\n";
      if ($can_take)
      {
         echo '   <div class="action">'."\n";
         echo '      <a href="?takecards">Take</a>'."\n";
         echo '   </div>'."\n";
      }
      echo '</div>'."\n";


      // Current Player's Hand Section

      echo '<div class="player hand'.($can_draw ? " unavailable" : "").'">'."\n";
      echo '   <div class="header">Cards in hand:</div>'."\n";
      echo "\n";
      echo '   <div class="cards">'."\n";
      echo "\n";
      foreach ($cards_inHand as $card)
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
         echo '      <a href="?draw">Draw</a>'."\n";
         echo '   </div>'."\n";
      }
      echo '</div>'."\n";


      // Opponents Section

      echo '<div class="opponents">'."\n";
      foreach ($opponents as $player)
      {
         echo '   <div class="player">'."\n";
         echo '      <div class="hand">'."\n";
         echo "\n";
         for ($i=0; $i < $player['cards']; $i++)
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

      echo "\n";
      echo '<script type="text/javascript">'."\n";
      echo 'function play (card) {'."\n";

      if ($player_onTurn == $my_pid)
         echo '   window.location.href = "?play="+card;'."\n";
      else
         echo '   return true;'."\n";

      echo '}'."\n";
      echo '</script>'."\n";
      echo "\n";


      // polling
      $pollfor = 'game:'.$g['GameID'];
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
      $g = mysql_("SELECT p.GameID as GameID, g.Name as Name, p.PID as PID, g.PlayerCount as playerCount, g.startingHand as startingHand, g.turnDraw as turnDraw, g.takeDraw as takeDraw, g.emptyDraw as emptyDraw, g.forcedAnswer as forcedAnswer, g.forcedRaise as forcedRaise FROM rsk_players as p, rsk_games as g WHERE p.GameID = g.GID AND p.Player='".$_SESSION['user']."' AND p.Finished='0' LIMIT 1", MYSQL_ASSOC);


      echo '<html>'."\n";
      echo '<head>'."\n";
      echo '   <title>Risk Jack - Pre-Game</title>'."\n";
      echo '   <script type="text/javascript" src="?js&call&poll&clean"></script>'."\n";
      echo '   <link rel="stylesheet" type="text/css" href="?css&pregame" />'."\n";
      echo '</head>'."\n";

      echo '<body>'."\n";
      echo "\n";

      echo '<div class="pre-game main">'."\n";
      echo '   <div class="name">'.$g['Name'].'</div>'."\n";
      echo "\n";

      echo '   <div class="ruleset">'."\n";
      echo '      <div class="header">Rules</div>'."\n";
      echo "\n";

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

      if ($g['PID'] == 1)
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

      $playersJoined = mysql_("SELECT GameID FROM rsk_players WHERE GameID='".$g['GameID']."' AND Finished='0'", true);

      echo '   <div class="players">'."\n";
      echo '      <div class="header">Players</div>'."\n";
      echo '      <span class="joined">'.$playersJoined.'</span>'."\n";
      echo '       /'."\n";
      echo '      <span class="maximum">'.$g['playerCount'].'</span>'."\n";
      echo "\n";

      echo '      <div class="slots">'."\n";
      for ($i=0; $i < $g['playerCount']; $i++)
      {
         $slot = mysql_("SELECT Player FROM rsk_players WHERE GameID='".$g['GameID']."' AND PID='".($i+1)."'");
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
            echo '         </div>'."\n";
         }
      }
      echo '      </div>'."\n";
      echo "\n";

      if ($g['PID'] == 1)
      {
         echo '      <script type="text/javascript" src="?js&movables"></script>'."\n";
         echo "\n";
      }

      echo '   </div>'."\n";
      echo "\n";

      echo '   <div class="actions">'."\n";
      echo '      <button onclick="window.location.href=\'?startgame\';">Start Game</button>'."\n";
      echo '      <button onclick="window.location.href=\'?leavegame\';">Leave Game</button>'."\n";
      echo '   </div>'."\n";
      echo "\n";

      echo '</div>'."\n";

      echo "\n";
      echo '</body>'."\n";

      // polling
      $pollfor = 'game:'.$g['GameID'];
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

         echo '      <div class="game" onclick="window.location.href=\'?join='.$game['GID'].'\';">'."\n";
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
   echo '      </script>'."\n";
   echo '   </div>'."\n";
   echo '   <div class="stage" id="s2">'."\n";
   echo '      <form action="?login&s2" method="POST">'."\n";
   echo '         <input type="hidden" name="username" id="inp:s2-user" value="" />'."\n";
   echo '         <label>'."\n";
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