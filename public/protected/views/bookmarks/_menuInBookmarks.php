<div class="bookmarksContainer">
    <?php foreach ($menuInBookmarks as $menu) :?>
        <div class="menu">
            <?php if (0 < $menu['countArticleInMenu']) :?>
                <?php echo CHtml::link('
                    <span class="name">'.$menu['title'].'</span>
                    <span class="count">(<span class="value red">'.$menu['countArticleInMenu'].'</span>)</span>
                ', 'javascript:void(0)', array(
                    'class'         => 'userListArticles',
                    'listType'      => 'cabinet_bookmarks',
                    'data-idMenu'   => $menu['idMenu'],
                ));?>
            <?php else :?>
                <span class="name"><?php echo $menu['title']?></span>
                <span class="count"><?php echo '(<span class="value">'.$menu['countArticleInMenu'].'</span>)'?></span>
            <?php endif;?>
        </div>
        <div class="categorys">
            <?php foreach ($menu['categorys'] as $category) :?>
                <?php if (0 < $category['countArticleInCategory']) :?>
                    <?php echo CHtml::link('
                        - <span class="name">'.$category['title'].'</span>
                        <span class="count">(<span class="value red">'.$category['countArticleInCategory'].'</span>)</span>
                    ', 'javascript:void(0)', array(
                        'class'             => 'userListArticles',
                        'listType'          => 'cabinet_bookmarks',
                        'data-idMenu'       => $category['idMenu'],
                        'data-idCategory'   => $category['idCategory'],
                    ));?>
                <?php else :?>
                    - <span class="name"><?php echo $category['title']?></span>
                    <span class="count"><?php echo '(<span class="value">'.$category['countArticleInCategory'].'</span>)'?></span>
                <?php endif;?>
                <br/>
            <?php endforeach;?>
        </div>
    <?php endforeach;?>
</div>

