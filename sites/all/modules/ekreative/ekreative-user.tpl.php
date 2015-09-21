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
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">User Info</a></li>
        <li role="presentation"><a id="user-calendar" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Calendar</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <?php if ($user[$_GET['id']]->uid != 0 && $user[$_GET['id']]->uid != 1 ):?>
            <div class="user-full">
                <h1 style="font-weight: bold"><?php print $user[$_GET['id']]->name;?></h1>
                <div class="photo-user">
                    <img src="/sites/default/files/styles/thumbnail/public/pictures/<?php print $user[$_GET['id']]->picture->filename; ?>" alt="<?php print $user[$_GET['id']]->name; ?>">
                </div>
                <section>
                    <h2 style="font-weight: bold">Projects</h2>
                    <table class="table">
                        <thead>
                            <th>
                                Project
                            </th>
                            <th>
                                Start Time
                            </th>
                            <th>
                                End Time
                            </th>
                        </thead>
                        <tbody>
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
                            $project = node_load($id->entity_id);?>
<!--//                            if(strtotime('now') > strtotime($project->field_start_date_project['und'][0]['value']) && strtotime('now') < strtotime($project->field_end_date['und'][0]['value'])){ ?>-->
                               <tr>
                                <td>
                                    <?php print $project->title; ?>
                                </td>
                                <td>
                                    <?php print date('d M Y', strtotime($project->field_start_date_project['und'][0]['value'])); ?>
                                </td>
                                <td>
                                    <?php print date('d M Y', strtotime($project->field_end_date['und'][0]['value'])); ?>
                                </td>
                            </tr>

                         <?php } ?>

                        </tbody>
                    </table>
                </section>
                <section>
                    <h2 >eKreative</h2>
                    <table class="table">
                        <thead>
                        <th>
                            Start Date
                        </th>
                        <th>
                            Position
                        </th>
                        <th>
                            Technology
                        </th>
                        <th>
                            eKreative email
                        </th>
                        <th>
                            Login Mac
                        </th>
                        <th>
                            Pass Mac
                        </th>
                        <th>
                            Recovery Key
                        </th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <?php print date('d M Y', strtotime($user[$_GET['id']]->field_start_date['und'][0]['value'])); ?>
                            </td>
                            <td>
                                <?php
                                $position = array_keys($user[$_GET['id']]->roles);
                                print $user[$_GET['id']]->roles[$position[1]]; ?>
                            </td>
                            <td>
                                <?php
                                $query = db_select('field_data_field_skills','n');
                                $query->fields('n',array('field_skills_value'));
                                $query->condition('n.entity_id', $user[$_GET['id']]->uid);
                                $res = $query->execute()->fetchAll();
                                print "<span>".$res[0]->field_skills_value."</span>";
                                ?>
                            </td>
                            <td>
                                <?php print $user[$_GET['id']]->field_ekreative_email['und'][0]['value']; ?>
                            </td>
                            <td>
                                <?php print $user[$_GET['id']]->field_login_to_computer['und'][0]['value']; ?>
                            </td>
                            <td>
                                <?php print $user[$_GET['id']]->field_password_to_computer['und'][0]['value']; ?>
                            </td>
                            <td>
                                <?php print $user[$_GET['id']]->field_mac_recovery_keys['und'][0]['value']; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
                <section>
                    <h2>Personal Information</h2>
                    <table class="table">
                        <thead>
                        <th>
                            Date of birth
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            Skype
                        </th>
                        <th>
                            Email
                        </th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <?php print date('d M Y', strtotime($user[$_GET['id']]->field_date_of_birth['und'][0]['value'])); ?>
                            </td>
                            <td>
                                <?php print $user[$_GET['id']]->field_phone['und'][0]['value']; ?>
                            </td>
                            <td>
                                <?php print $user[$_GET['id']]->field_skype['und'][0]['value']; ?>
                            </td>
                            <td>
                                <?php print $user[$_GET['id']]->init; ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="profile">
            <div id="calendar"></div>
            <script>
                (function($){

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
                        events: function (start, end, callback) {
                            $('#user-calendar').on('click', function(){
                                $.ajax({
                                    url: '/ekreative/user/calendar?id=' + <?php echo $_GET['id'] ?>,
                                    data: {},
                                    success: function (data) {
                                        console.log(data);
                                        callback(data);
                                    }
                                });
                            });
                        }
                    });
                })(jQuery);

            </script>

        </div>
    </div>

</div>



        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        (function($){
            $('#myTabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            });
        })(jQuery);
    </script>

    <?php endif; ?>
