<?php //foreach($users as $user): ?>
<!--    <h1>--><?php //print l($user->name,'ekreative/user',array('query' => array('id' => $user->uid))); ?><!--</h1>-->
<?php //endforeach; ?>
<?php
//echo '<pre>';
//var_dump($users);
//echo '</pre>';
//exit;?>
<?php foreach($users as $user):?>
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
                    $query = db_select('field_data_field_technology','n');
                    $query->fields('s',array('name'));
                    $query->leftJoin('taxonomy_term_data','s','s.tid = n.field_technology_tid');
                    $query->condition('n.entity_id', $user->uid);
                    $res = $query->execute()->fetchAll();
                    foreach ($res as $skill){
                        print "<span>".$skill->name.", </span>";
                    }
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
    <?php endforeach; ?>