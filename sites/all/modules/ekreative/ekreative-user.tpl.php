<?php //foreach($users as $user): ?>
    <!--    <h1>--><?php //print l($user->name,'ekreative/user',array('query' => array('id' => $user->uid))); ?><!--</h1>-->
<?php //endforeach; ?>
<?php
//echo '<pre>';
//var_dump($user[$_GET['id']]->uid);
//echo '</pre>';
//exit;?>

<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <?php if ($user[$_GET['id']]->uid != 0 && $user[$_GET['id']]->uid != 1 ):?>
            <div class="user-full">
                <h1><?php print l($user[$_GET['id']]->name,'ekreative/user',array('query' => array('id' => $user[$_GET['id']]->uid))); ?></h1>
                <div class="photo-user">
                    <img src="/sites/default/files/styles/thumbnail/public/pictures/<?php print $user[$_GET['id']]->picture->filename; ?>" alt="<?php print $user[$_GET['id']]->name; ?>">
                </div>
                <div class="user-info">

                    <?php
                    $query = db_select('field_data_field_developer_s_','n');
                    $query->fields('n',array('entity_id'));
                    $query->condition('n.field_developer_s__uid', $user[$_GET['id']]->uid);
                    $entity_id = $query->execute()->fetchAll();
                    //                    echo '<pre>';
                    //                    var_dump($entity_id);
                    //                    echo '</pre>';
                    //                    exit;
                    $project = array();
                    foreach ($entity_id as $id){
                        $project = node_load($id->entity_id);
//                        echo '<pre>';
//                        var_dump($project);
//                        echo '</pre>';
//                        exit;
                        print "<h3>Current Project:</h3>";
                        print "<span>".$project->title."</span>";
                        print "<h3>Start date project:</h3>";
                        print "<span>".date('d M Y', strtotime($project->field_start_date_project['und'][0]['value']))."</span>";
                        print "<h3>End date project:</h3>";
                        print "<span>".date('d M Y', strtotime($project->field_end_date['und'][0]['value']))."</span>";
                    }
                    ?>

                    <div class="position">
                        <h3>Position:</h3>
                <span><?php
                    $position = array_keys($user[$_GET['id']]->roles);
                    print $user[$_GET['id']]->roles[$position[1]]; ?></span>
                    </div>
                    <div class="skills">
                        <h3>Skills:</h3>
                <span>
                    <?php
                    $query = db_select('field_revision_field_technology','n');
                    $query->fields('s',array('name'));
                    $query->leftJoin('taxonomy_term_data','s','s.tid = n.field_technology_tid');
                    $res = $query->execute()->fetchAll();
                    foreach ($res as $skill){
                        print "<span>".$skill->name.", </span>";
                    }
                    ?>

                </span>
                    </div>
                    <div class="user-status">
                        <h3>Status:</h3>
                        <span>Available</span>
                    </div>
                    <div class="user-birth">
                        <h3>Date of birth:</h3>
                        <span><?php print date('d M Y', strtotime($user[$_GET['id']]->field_date_of_birth['und'][0]['value'])); ?></span>
                    </div>
                    <div class="user-phone">
                        <h3>Phone:</h3>
                        <span><?php print $user[$_GET['id']]->field_phone['und'][0]['value']; ?></span>
                    </div>
                    <div class="user-skype">
                        <h3>Skype:</h3>
                        <span><?php print $user[$_GET['id']]->field_skype['und'][0]['value']; ?></span>
                    </div>
                    <div class="user-email">
                        <h3>Email:</h3>
                        <span><?php print $user[$_GET['id']]->init; ?></span>
                    </div>
                    <div class="user-ekreative-email">
                        <h3>eKreative email:</h3>
                        <span><?php print $user[$_GET['id']]->field_ekreative_email['und'][0]['value']; ?></span>
                    </div>
                    <div class="user-start-date">
                        <h3>Start Date:</h3>
                        <span><?php print date('d M Y', strtotime($user[$_GET['id']]->field_start_date['und'][0]['value'])); ?></span>
                    </div>
                    <div class="user-login">
                        <h3>Login to computer:</h3>
                        <span><?php print $user[$_GET['id']]->field_login_to_computer['und'][0]['value']; ?></span>
                    </div>
                    <div class="user-password">
                        <h3>Password to computer:</h3>
                        <span><?php print $user[$_GET['id']]->field_password_to_computer['und'][0]['value']; ?></span>
                    </div>
                    <div class="user-recovery">
                        <h3>Recovery key to computer:</h3>
                        <span><?php print $user[$_GET['id']]->field_mac_recovery_keys['und'][0]['value']; ?></span>
                    </div>

                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="profile">
            <div id="calendar"></div>
            <script type="text/javascript">
                //            (function($){
                //                $('#calendar').fullCalendar({
                //                    header: {left: 'prev,next today',center: 'title',right: 'month,agendaWeek,agendaDay'},
                //                    events: [
                //                        {
                //                            title: 'Event1',
                //                            start: '2015-09-09'
                //                        },
                //                        {
                //                            title: 'Event2',
                //                            start: '2015-05-05'
                //                        }
                //                    ],
                //                    color: 'yellow',   // an option!
                //                    textColor: 'black' // an option!
                //                });
                //            })(jQuery);
                (function($){
                    $('#myTabs a').click(function (e) {
                        e.preventDefault()
                        $(this).tab('show')
                    });
                    $('#calendar').fullCalendar({
                        firstDay : 1,
                        header: {left: 'prev,next today',center: 'title',right: 'month,agendaWeek,agendaDay'},
                        editable: false,
                        timeFormat: 'HH:mm',
                        eventClick: function(calEvent, jsEvent, view){
                            var events = $('#calendar').fullCalendar('clientEvents');
                            for(var key in events){
                                events[key].backgroundColor = '#3a87ad';
                            }
                            calEvent.backgroundColor = '#008000';
                            $('#calendar').fullCalendar( 'rerenderEvents' );

                            $("input.deliveryTime").val(calEvent.deliveryTimeFOrmat);
                            return false;
                        },
                        events: function(start, end, callback) {
                            $.ajax({
                                url: '/ekreative/user/calendar?id=' + <?php echo $_GET['id'] ?>,
                                data: {},
                                success: function(data){
                                    callback(data);
                                }
                            });
                        }
                    });
                })(jQuery);
            </script>
        </div>
        <div role="tabpanel" class="tab-pane" id="messages">...</div>
        <div role="tabpanel" class="tab-pane" id="settings">...</div>
    </div>

</div>



        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">


        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <?php endif; ?>
