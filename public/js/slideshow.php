<style>
    /* Container: stack all sliders side by side (or you can do one on top of the other if you prefer),
    but with space in between to see the zigzag offset. */
    .slideshow-container {
        display: flex;
        justify-content: center;
        gap: 20px;               /* Space between each slider cell */
        margin: 2rem auto;
        flex-wrap: nowrap;       /* If you want them on one line; set to 'wrap' if you have many sliders */
    }

    /* Each slider cell: keep the width but apply a transform to create a zigzag effect */
    .slideshow-cell {
        width: 30vw;
        transition: transform 0.3s ease;
    }

    /* Zigzag offset:
       - Odd-numbered sliders move down slightly and rotate a bit
       - Even-numbered sliders move up slightly and rotate the opposite way */
    .slideshow-cell:nth-child(odd) {
        transform: translateY(20px) rotate(-2deg);
    }

    .slideshow-cell:nth-child(even) {
        transform: translateY(-20px) rotate(2deg);
    }

    /* Keep your original fadein styling, but make the images more transparent and preserve object-fit. */
    .fadein {
        position: relative;
        height: 300px;
        width: 100%;
        margin: 0;
        overflow: hidden;
        background: #ebebeb;
        border-radius: 10px;
    }

    .fadein img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Lower opacity for semi-transparency */
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    /* Optional: if you want a hover effect to restore full opacity */
    .fadein:hover img {
        opacity: 1;
    }

</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
    $(function () {
        function animateSlideshows(slideshowSelector) {
            $(slideshowSelector + ' .fadein img:gt(0)').hide();
            setInterval(function () {
                $(slideshowSelector + ' .fadein :first-child').fadeOut().next('img').fadeIn().end().appendTo(slideshowSelector + ' .fadein');
            }, 3000);
        }

        <?php
        $folders = [
            "../resources/slideshow/1",
            "../resources/slideshow/2",
            "../resources/slideshow/3"
        ];

        for ($i = 0; $i < 3; $i++):
        $dir = $folders[$i];
        ?>
        setTimeout(function () {
            animateSlideshows('.slideshow-cell:nth-child(<?php echo $i + 1; ?>)');
        }, <?php echo $i * 5000; ?>);
        <?php endfor; ?>
    });
</script>

<div id="my_slideshow" class="slideshow-container" style="padding: 20px">
    <?php

    for ($i = 0; $i < 3; $i++):
        $dir = $folders[$i];
        ?>
        <div class="slideshow-cell">
            <div class="fadein">
                <?php
                $scan_dir = scandir($dir);
                foreach($scan_dir as $img):
                    if(in_array($img, array('.', '..')))
                        continue;
                    ?>
                    <img src="<?php echo $dir.'/'.$img ?>" alt="<?php echo $img ?>">
                <?php endforeach; ?>
            </div>
        </div>
    <?php endfor; ?>
</div>