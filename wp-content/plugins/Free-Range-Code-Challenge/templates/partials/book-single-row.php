<tr>
<td>
    <?php
    $title = get_the_title();
    $title = $title ? $title : '(no-title)';
    echo '<h5 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">'. esc_attr($title) .'</a></h5>';
    ?>
</td>
<td><?php the_field('book_description', get_the_ID()); ?></td>
</tr>