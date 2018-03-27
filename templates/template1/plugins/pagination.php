<p class="pages">
    <small>Page 1 of <?=$pages_count?></small>
    <?php
        if($pages_count !== 0){
            for($i=1; $i <= $pages_count; $i++) {
                if($i === $current_page) {
                    echo '<span>'.$i.'</span>';
                } else {
                    echo '<a href="?page='.$i.'">'.$i.'</a>';
                }
            }
            //TODO: нормальная пагинация
        }

    ?>
</p>
