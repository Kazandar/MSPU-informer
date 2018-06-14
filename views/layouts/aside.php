<aside>
    <h2>Категории</h2>
    <ul>
        <?php
        foreach ($categoriesList as $cat):?>
            <li><a href="<?php echo "/events/$cat[title_translit]"?>" <?php if(preg_match("~$cat[title_translit]~",$_SERVER['REQUEST_URI'])) echo " class = \"active\"";?>><?php echo $cat['title'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</aside>