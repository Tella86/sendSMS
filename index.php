<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <style type="text/css">
        #nav{
            background-color: gray;
            height: 50px;
            color: white;
        }
    </style>
    <body>
        <?php include 'db_connect.php' ?>
        <!-- compose share centered Modal -->
        <nav id="nav">

            <center><h2 class="text-uppercase"><img src="imgLOGO.png"> free project</h2></center>
        </nav>
        <div>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><center>Send SMS</center></h3>
                    </div>
                    <div class="modal-body">
                        <!-- General Form Elements -->
                        <form action="" method="post">



                            <?php
                            //this line of code isfor select option to for dropdown the user
                            $fetch_con = $connect->query("SELECT * FROM contact") or die($connect->error());
                            ?>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Recepient <label style="color: red;">*</label></label>
                                <div class="col-sm-9">
                                    <select name="to_user_" class="form-control" aria-label="Default select example"  required/>
                                    <option selected disabled>-Select From Contacts-</option>
                                    <?php while ($contact = $fetch_con->fetch_assoc()): ?>
                                        <option> <?php echo $contact['names'] ?></option>
                                    <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">

                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword" class="col-sm-3 col-form-label">Message</label>
                                <div class="col-sm-9">
                                    <textarea name="message" class="form-control" style="height: 100px" placeholder="start typing..."></textarea>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button id="confirm" class="btn btn-primary btn-sm" name="send">Send</button>
                    </div>
                    </form><!-- End General Form Elements -->
                </div>
            </div>
        </div>
        <?php
        if (isset($_POST['send'])) {
            $names = $_POST['to_user_'];
            $msg = $_POST['message'];

            $result = $connect->query("SELECT phone FROM contact WHERE names = '$names'") or die($connect->error());

            $rows = $result->num_rows;

            for ($i = 0; $i < $rows; $i++) {

                $fetch = $result->fetch_array();
                $num = $fetch['phone'];

                require_once('smsGatewayV4.php');
                $token = "enter you token here from smsgateway website";

                $message = "From source code hero" . $msg;

                $deviceID = "paste your device id from sms gateway website without qoutes";
                $options = [];

                $smsGateway = new SmsGateway($token);
                $sent = $smsGateway->sendMessageToNumber($num, $message, $deviceID, $options);
            }
        }//end sending sms
        ?>

    </body>
    <script src="bootstrap.min.js"></script>
</html>