<?php //foreach($users as $user): ?>
<!--    <h1>--><?php //print l($user->name,'ekreative/user',array('query' => array('id' => $user->uid))); ?><!--</h1>-->
<?php //endforeach; ?>
<?php
//echo '<pre>';
//var_dump($users);
//echo '</pre>';
//exit;?>
    <form class="form-horizontal" style="margin-bottom: 50px; background: #cccccc; padding: 20px" method="post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" name="name" placeholder="Name">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Position</label>
            <div class="col-sm-10">
                <select class="form-control" name="position">
                    <option value="0"></option>
                    <option value="4">Manager</option>
                    <option value="6">Developer</option>
                    <option value="8">Designer</option>
                    <option value="5">QA</option>
                    <option value="7">Client</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Skills</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" name="skills" placeholder="Skills">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="status" id="blankCheckbox" value="available" aria-label="Php"> Available
                </label>
            </div>
                </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Search</button>
            </div>
        </div>
    </form>
<?php
    if (isset($_POST['name'])){
        $name = db_select('users','n');
        $name->fields('n', array('uid'));
        if (isset($_POST['name'])){
            $name->condition('n.name', '%'.$_POST['name'].'%', 'LIKE');
        }
        if (isset($_POST['skills']) && $_POST['skills'] != ''){
            $name->leftJoin('field_data_field_skills', 's', 'n.uid = s.entity_id');
            $name->condition('s.field_skills_value', '%'.$_POST['skills'].'%', 'LIKE');
        }
        if (isset($_POST['position']) && $_POST['position'] != 0){
            $name->leftJoin('users_roles', 'rid', 'n.uid = rid.uid');
            $name->condition('rid.rid', $_POST['position']);
        }

        $rez_name = $name->execute()->fetchAll();
        foreach ($rez_name as $user_id){
            $users = entity_load('user', array($user_id->uid));
            foreach($users as $user):
            if ($user->uid != 0 && $user->uid != 1 ):?>
                <div class="user-teaser" style="margin-bottom: 20px; clear:both">
                    <div class="photo-user">
                        <img style="margin-bottom: 20px" src="/sites/default/files/styles/thumbnail/public/pictures/<?php print $user->picture->filename; ?>" alt="<?php print $user->name; ?>">
                    </div>
                    <div class="user-info">
                        <h1><?php print l($user->name,'ekreative/user',array('query' => array('id' => $user->uid))); ?></h1>
                        <table class="table" style="float: right; width:87% ">
                            <thead>
                            <th>
                                Position
                            </th>
                            <th>
                                Skills
                            </th>
                            <th>
                                Status
                            </th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <?php
                                    $position = array_keys($user->roles);
                                    print $user->roles[$position[1]]; ?>
                                </td>
                                <td>
                                    <?php
                                    $query = db_select('field_data_field_skills','n');
                                    $query->fields('n',array('field_skills_value'));
                                    $query->condition('n.entity_id', $user->uid);
                                    $res = $query->execute()->fetchAll();
                                    print "<span>".$res[0]->field_skills_value."</span>";
                                    ?>
                                </td>
                                <td>
                                    Available
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif;
                endforeach;
        }

    } else {
foreach($users as $user):?>
    <?php if ($user->uid != 0 && $user->uid != 1 ):?>
        <div class="user-teaser" style="margin-bottom: 20px; clear:both">
            <div class="photo-user">
                <img style="margin-bottom: 20px" src="/sites/default/files/styles/thumbnail/public/pictures/<?php print $user->picture->filename; ?>" alt="<?php print $user->name; ?>">
            </div>
            <div class="user-info">
                <h1><?php print l($user->name,'ekreative/user',array('query' => array('id' => $user->uid))); ?></h1>
                <table class="table" style="float: right; width:87% ">
                    <thead>
                    <th>
                        Position
                    </th>
                    <th>
                        Skills
                    </th>
                    <th>
                        Status
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <?php
                            $position = array_keys($user->roles);
                            print $user->roles[$position[1]]; ?>
                        </td>
                        <td>
                            <?php
                            $query = db_select('field_data_field_skills','n');
                            $query->fields('n',array('field_skills_value'));
                            $query->condition('n.entity_id', $user->uid);
                            $res = $query->execute()->fetchAll();
                            print "<span>".$res[0]->field_skills_value."</span>";
                            ?>
                        </td>
                        <td>
                            Available
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach;
    }
?>


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
