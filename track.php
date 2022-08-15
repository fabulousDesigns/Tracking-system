<?php
include_once('./config/config.php');
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

?>

<?php
include_once("header.php");
?>

<body class="text-white">
    <div class="container">
        <div class="navigation">
            <h6 class="welcome">Welcome <?php echo htmlspecialchars($_SESSION["first_name"]); ?></h6>
            <ul class="nav__menu">
                <li>
                    <a href="logout.php" name="logout" class="btn-logout">logout</a>
                </li>
            </ul>
        </div>
        <form class="row domain-search">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <h2 class="form-title">Track Your <strong>Cargo Now</strong></h2>
                        <p>Enter your Tracking number Here</p>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Enter your Tracking Number" />
                            <span class="input-group-addon"><input type="submit" value="Search" class="btn btn-primary" /></span>
                            <div class="timeline" id="parcel_history">

                            </div>

                        </div>
                    </div>
                    <p>
                        ex <strong>123456789</strong>
                    </p>
                    <div id="clone_timeline-item" class="d-none">
                        <div class="iitem">
                            <i class="fas fa-box bg-blue"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> <span class="dtime">12:05</span></span>
                                <div class="timeline-body">
                                    asdasd
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>

    </div>
</body>
<script>
    function track_now() {
        start_load()
        var tracking_num = $('#ref_no').val()
        if (tracking_num == '') {
            $('#parcel_history').html('')
            end_load()
        } else {
            $.ajax({
                url: 'ajax.php?action=get_parcel_heistory',
                method: 'POST',
                data: {
                    ref_no: tracking_num
                },
                error: err => {
                    console.log(err)
                    alert_toast("An error occured", 'error')
                    end_load()
                },
                success: function(resp) {
                    if (typeof resp === 'object' || Array.isArray(resp) || typeof JSON.parse(resp) === 'object') {
                        resp = JSON.parse(resp)
                        if (Object.keys(resp).length > 0) {
                            $('#parcel_history').html('')
                            Object.keys(resp).map(function(k) {
                                var tl = $('#clone_timeline-item .iitem').clone()
                                tl.find('.dtime').text(resp[k].date_created)
                                tl.find('.timeline-body').text(resp[k].status)
                                $('#parcel_history').append(tl)
                            })
                        }
                    } else if (resp == 2) {
                        alert_toast('Unkown Tracking Number.', "error")
                    }
                },
                complete: function() {
                    end_load()
                }
            })
        }
    }
    $('#track-btn').click(function() {
        track_now()
    })
    $('#ref_no').on('search', function() {
        track_now()
    })
</script>

</html>