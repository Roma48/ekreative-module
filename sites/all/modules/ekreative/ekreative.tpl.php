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
<div class="user-teaser">
    <div class="photo-user">
        <img src="/sites/default/files/styles/thumbnail/public/pictures/<?php print $user->picture->filename; ?>" alt="<?php print $user->name; ?>">
    </div>
    <div class="user-info">
            <h1><?php print l($user->name,'ekreative/user',array('query' => array('id' => $user->uid))); ?></h1>
            <div class="position">
                <h3>Position:</h3>
                <span><?php
                    $position = array_keys($user->roles);
                    print $user->roles[$position[1]]; ?></span>
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
    </div>
</div>
        <?php endif; ?>
    <?php endforeach; ?>