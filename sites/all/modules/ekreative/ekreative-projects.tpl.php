<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Projects</a></li>
    <li role="presentation"><a id="user-calendar" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Calendar</a></li>
</ul>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        <?php foreach($projects as $project):?>
            <!--    --><?php //echo "<pre>"; ?>
            <!--    --><?php //var_dump($project); ?>
            <!--    --><?php //echo "</pre>"; ?>
            <h1><?php print $project->title; ?></h1>
            <table class="table">
                <thead>
                <th>
                    Developers
                </th>
                <th>
                    Manager
                </th>
                <th>
                    Designer
                </th>
                <th>
                    Tester
                </th>
                <th>
                    Start Date
                </th>
                <th>
                    End Date
                </th>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <?php
                        foreach ($project->field_developer_s_['und'][0] as $uid){
                            $query = db_select('users','n');
                            $query->fields('n',array('name'));
                            $query->condition('n.uid', $uid);
                            $user_id = $query->execute()->fetchAll();
                            foreach ($user_id as $dev) {
                                print $dev->name;
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($project->field_manager_project['und'][0] as $uid){
                            $query = db_select('users','n');
                            $query->fields('n',array('name'));
                            $query->condition('n.uid', $uid);
                            $user_id = $query->execute()->fetchAll();
                            foreach ($user_id as $dev) {
                                print $dev->name;
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($project->field_designer['und'][0] as $uid){
                            $query = db_select('users','n');
                            $query->fields('n',array('name'));
                            $query->condition('n.uid', $uid);
                            $user_id = $query->execute()->fetchAll();
                            foreach ($user_id as $dev) {
                                print $dev->name;
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($project->field_qa_project['und'][0] as $uid){
                            $query = db_select('users','n');
                            $query->fields('n',array('name'));
                            $query->condition('n.uid', $uid);
                            $user_id = $query->execute()->fetchAll();
                            foreach ($user_id as $dev) {
                                print $dev->name;
                            }
                        }
                        ?>
                    </td>
                    <td>
                        <?php print date('d M Y', strtotime($project->field_start_date_project['und'][0]['value'])); ?>
                    </td>
                    <td>
                        <?php print date('d M Y',strtotime($project->field_end_date['und'][0]['value'])); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php endforeach; ?>
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
                                url: '/ekreative/projects/calendar',
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