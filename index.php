<?php
include 'functions.php';
if (check_core_db($core_db_file) == "db_connect") {
    $core_db = connect_sql3_db($core_db_file);
    include 'action_check.php';
    ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<title>Lan Menu Maker</title>
                <link rel="author" href="humans.txt" />
                <meta charset="UTF-8">
                <meta name="description" content="Menu list of links to Lan URLs">
                <meta name="version" content=".04-github">
                <meta name="keywords" content="HTML,CSS,PHP,SQLite">
                <meta name="author" content="Jay Carter">
		<style>
			* { 
				/* Basic CSS reset */
				margin:0; 
				padding:0;
			}

			body {
				/* These styles have nothing to do with the ribbon */
				background:url(img/dark_wood.png) 0 0 repeat;
                                background-color: gray;
				padding:2px 0 2px 0;
				margin:auto;
				text-align:center;
			}

			.ribbon {
				display:inline-block;
			}

			.ribbon:after, .ribbon:before {
				margin-top:0.5em;
				content: "";
				float:left;
				border:1.5em solid #fff;
			}

			.ribbon:after {
				border-right-color:transparent;
			}

			.ribbon:before {
				border-left-color:transparent;
			}

			.ribbon a:link, .ribbon a:visited { 
				color:#000;
				text-decoration:none;
			    float:left;
			    height:3.5em;
				overflow:hidden;
			}

			.ribbon span {
				background:#fff;
				display:inline-block;
				line-height:3em;
				padding:0 1em;
				margin-top:0.5em;
				position:relative;
				transition: background-color 0.2s, margin-top 0.2s;
			}

			.ribbon a:hover span {
				background:#FFD204;
				margin-top:0;
			}
                        
 			#active_ribbon{
				background:#FFD204;
				margin-top:0;
			}                       

			.ribbon span:before {
				content: "";
				position:absolute;
				top:3em;
				left:0;
				border-right:0.5em solid #9B8651;
				border-bottom:0.5em solid #fff;
			}

			.ribbon span:after {
				content: "";
				position:absolute;
				top:3em;
				right:0;
				border-left:0.5em solid #9B8651;
				border-bottom:0.5em solid #fff;
			}
                        
                        /* The alert message box */
                        .alert {
                            padding: 20px;
                            background-color: #f44336; /* Red */
                            color: white;
                            margin-bottom: 15px;
                        }

                        /* The close button */
                        .closebtn {
                            margin-left: 15px;
                            color: white;
                            font-weight: bold;
                            float: right;
                            font-size: 22px;
                            line-height: 20px;
                            cursor: pointer;
                            transition: 0.3s;
                        }

                        /* When moving the mouse over the close button */
                        .closebtn:hover {
                            color: black;
                        }

		</style>
	</head>
	<body>
            
           <div class='ribbon'>
               
                   <?PHP
                   if (isset($_GET['page'])) {
                       $cp = $_GET['page'];
                   } else {
                       $cp = "Home";
                   }
                   $menu_result = $core_db->query('SELECT * FROM pages order by sorter');
                   // Loop thru all data from pages table    
                   foreach ($menu_result as $p) {
                       if ($cp == $p['name']) {
                           $span = "<span id='active_ribbon'>";
                       } else {
                           $span = "<span>";
                       }
                       echo "   <a href='?page=" . $p['name'] . "'>" . $span . $p['name'] . "</span></a>
             ";
                   }

                   echo "</div> ";
                   if (isset($cp) && ($cp == "Home")) {
                       echo "<BR><BR><BR><font color='white'> Welcome Home.</font>";
                   } elseif ($cp == "Configure") {
                       include 'configure.php';
                   } else {
//      echo "Something when wrong, please reload the page.";
                       $iframe_result = $core_db->query("SELECT url FROM pages WHERE name='$cp'");
                       while ($row = $iframe_result->fetch(PDO::FETCH_ASSOC)) {
                           $url = $row['url'];
                           ?><iframe src="<?PHP echo $url; ?>" style="position:fixed; top:70px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">
                               Your browser doesn't support iframes></iframe> <?PHP
           }
       }
                   ?>   

               </body>
                            </html>    
    <?PHP
} else {
    echo "<div class=\"alert\">
  <span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
  Houston, we've had a problem here!
</div>";
}