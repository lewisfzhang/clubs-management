<!doctype html>
<?php
  $studentid = NULL;
  $email = NULL;
  if (!isset($_COOKIE["studentid"]) && !isset($_GET['studentid'])) {
      echo "you ain't got the cookies for the job, son";
      header("Location: http://times.bcp.org/clubs/browseLogin.php?state=0") ;
  }
  else {
    if (isset($_COOKIE["studentid"])) {
        $studentid = $_COOKIE["studentid"];
        $email = $_COOKIE["studentemail"];
    }
    else {
        $studentid = $_GET["studentid"];
        $email = $_GET["email"];
    }
  }
  $data = (file_get_contents("http://times.bcp.org/clubs/getDataFromId.php?id=" . $studentid));
  $emailData = file_get_contents("http://times.bcp.org/clubs/getDataFromEmail.php?email=" . $email);
  if (!(($data) == ($emailData))) {
    header("Location: http://times.bcp.org/clubs/browseLogin.php?state=1") ;
  }
  else {
    $actualData = json_decode($emailData);
    $studentname = $actualData->{'firstname'} . " " . $actualData->{'lastname'};
    $studentemail = $actualData->{'email'};
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
                $("#addedalert").hide();
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
            var joinClub = function(el) {
                var moddedClubId = $(el).parents("tr").children(".clid").text();
                var clubName = $(el).parents("tr").children(".clubname").text();
                var realClubId = parseInt(moddedClubId) - 5343;
                var studentId = parseInt(<?php echo $studentid ?>);
                var jsonObj = new Object();
                jsonObj.studentID = studentId;
                jsonObj.clubID = realClubId;
                $.post("addMemberships.php", {json: "["+JSON.stringify(jsonObj)+"]"}, function(data, status) {
                    if (status == "success") {
                        console.log(data);
                        orderRows();
                        $("#addedalert").show();
                    }
                });
            }
            var removeFromClub = function(el) {
                var moddedClubId = $(el).parents("tr").children(".clid").text();
                var clubName = $(el).parents("tr").children(".clubname").text();
                var realClubId = parseInt(moddedClubId) - 5343;

                var email = (<?php echo json_encode($studentemail) ?>);
                $.get( "http://times.bcp.org/clubs/removeWithEmail.php?email=" + email + "&clubid=" + realClubId, function( data ) { 
                    if(data == "Record deleted successfully") {
                        console.log(data);
                        orderRows();
                        $("#removedalert").show();
                    }
                });
            }

            function orderRows() {
                $("#loading").show();
                function addRow(value, joined) {
                    if (parseInt(value.id) == 111111) {
                        return;
                    }
                    var stringToAppend = '<tr><td class="clubname">' + value.name +'</td><td class="category">' + value.category +'</td><td class="leaders">' + value.leaders + 
                    '</td><td class="clid hidden">' + (parseInt(value.id) + 5343) +'</td><td class="description">' + value.description + '</td>';
                    if (joined) {
                        stringToAppend += '<td><button class = "btn btn-danger btn-xs" onclick="removeFromClub(this)">Leave Club</button></td></tr>';
                    }
                    else {
                        stringToAppend += '<td><button class = "btn btn-success btn-xs" onclick="joinClub(this)">Join Club</button></td></tr>';
                    }
                    stringToAppend += ''
                    $("#clubList").append(stringToAppend);
                }
                var dataArr = null;
                var studentId = parseInt(<?php echo $studentid ?>);
                $.get("http://times.bcp.org/clubs/getClubsWithInfo.php", function(data) {
                    var dataArr = JSON.parse(data);
                    var copy = dataArr.slice(0);
                    var joinedClubs = [];
                    var others = [];
                    var indices = [];
                    var i = 0;
                    $.each(dataArr, function(index, value) {
                        $.get("http://times.bcp.org/clubs/isMember.php?studentid=" + <?php echo $studentid ?> + "&clubid=" + value.id, function(data) {
                            if (data == "TRUE") {
                                indices.push(index);
                            }
                            if (index >= dataArr.length - 1) {
                                console.log(indices);
                                $.each(dataArr, function(index2, value2) {
                                    if (indices.indexOf(index2) > -1) {
                                        joinedClubs.push(dataArr[index2]);
                                    }
                                    else {
                                        others.push(dataArr[index2]);
                                    }
                                });
                                $("#clubList tr").remove();
                                $("#clubList").append("<tr><td><strong>Club Name</strong></td><td><strong>Category</strong></td><td><strong>Leaders</strong></td><td><strong>Description</strong></td><td><strong>Actions</strong></td></tr>");
                                console.log(joinedClubs.length);
                                $.each(joinedClubs, function(index, value) {
                                    addRow(value, true);
                                });
                                $.each(others, function(index, value) {
                                    addRow(value, false);
                                });
                                var stringToAppend = '<tr><td class="clubname">' + 'Chanan Fan Club' +'</td><td class="category">' + 'Diversity and Culture' +'</td><td class="leaders">' + 'Barack Obama, The Buddha, and Margaret Thatcher' + '</td><td class="clid hidden">' + 000000 +'</td><td class="description">' + 'This is a club dedicated to praising the glorious Chanan Walia. This club has absolutely no commitments (except for praising Chanan, of course). Click the Join button for instant Chanan-y goodness.' + '</td><td><button class = "btn btn-success btn-xs" id = "chananbutton">Join Club</button></td></tr>';
                                $("#clubList").append(stringToAppend);
                                $("#loading").hide();
                                $("#chananbutton").mousedown(function() {
                                    if ($("#special").is(':hidden')) {
                                        $("#special").show();
                                        $("#chananbutton").removeClass("btn-success").addClass("btn-danger");
                                        $("#chananbutton").text("Leave Club");
                                        window.scrollBy(0, 50);
                                    }
                                    else {
                                        $("#chananbutton").removeClass("btn-danger").addClass("btn-success");
                                        $("#chananbutton").text("Join Club");
                                    }
                                });
                                $("#chananbutton").mouseup(function() {
                                    $("#special").hide();
                                });
                            }
                        });
                    });
                });
            }

            $(function() {
                $("#special").hide();
                $("#loading").hide();
                $("#removedalert").hide();
                orderRows();
            });
        </script>
        <style>
            #clubList {
                width:100%;
                overflow:hidden;
                text-overflow:ellipsis;
            }
            #description {
                max-width:10px;
                overflow:hidden;
                text-overflow:ellipsis;
            }
            #loading {
                position: absolute; width: 100%; height: 100%; background: url('loading.gif') no-repeat center center;
            }
            #special {
                position: absolute; width: 100%; height: 100%; background: url('BeautifulChanan.png') no-repeat center center;
            }
        </style>
    </head>
    <body>
        <div class="alert alert-success" id = "addedalert" role="alert">You were added successfully.</div>
        <div class="alert alert-danger" id = "removedalert" role="alert">You were removed successfully.</div>
        <div id="loading"></div>
        <div id = "clubz">
            <table class="table table-hover table-striped" id = "clubList">
            </table>
        </div>
        <div id = "special"></div>
    </body>
</html>
