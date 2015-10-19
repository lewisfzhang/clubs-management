<!doctype html>
<?php

  if (!isset($_COOKIE["studentname"]) || !isset($_GET['hash']) || !isset($_GET['hash'])) {
      echo "you ain't got the cookies for the job, son";
      header("Location: http://times.bcp.org/clubs/browseLogin.php") ;
  }
  else {
    echo "you got what it takes";
  }

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="favicon.ico">

        <title>BCP Clubs</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>
            $(function() {
                $("td[colspan=3]").find("p").hide();
                $("table").click(function(event) {
                    event.stopPropagation();
                    var $target = $(event.target);
                    if ( $target.closest("td").attr("colspan") > 1 ) {
                        $target.slideUp();
                    } else {
                        $target.closest("tr").next().find("p").slideToggle();
                    }                    
                });
            });
        </script>
        <style>
            #clubList {
                width:100%;
                white-space: nowrap;
                overflow:hidden;
                table-layout: fixed;
                text-overflow:ellipsis;
            }
            #description {
                max-width:10px;
                white-space: nowrap;
                overflow:hidden;
                text-overflow:ellipsis;
            }
        </style>
    </head>
    <body>
        <div id = "clubz">
            <table class="table table-hover table-striped" id = "clubList">
              <?php
                $json = file_get_contents("http://times.bcp.org/clubs/getClubsWithInfo.php");
                $data = json_decode($json);
              ?>
              <tr>
                <td><strong>Club Name</strong></td>
                <td><strong>Category</strong></td>
                <td><strong>Leaders</strong></td>
                <td><strong>Description</strong></td>
                <td><strong>Actions</strong></td>
              </tr>
                <?php
                  foreach($data as $object):
                ?>
                  <tr>
                    <td class="firstname"><?php echo $object->{'name'}?></td>
                    <td class="lastname"><?php echo $object->{'category'}?></td>
                    <td class = "email"><?php echo $object->{'leaders'}?></td>
                    <td><?php echo $object->{'description'}?></td>
                    <td>
                      <button class = "btn btn-success btn-xs" onclick="removeRow(this)">Join Club</button>
                    </td>              
                  </tr>
                  <tr><td colspan="3" id = "description"><p><?php echo $object->{'description'};?></p></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>
