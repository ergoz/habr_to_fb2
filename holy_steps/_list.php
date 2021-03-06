<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<ul>
    <?php
    $counter = 0;
    foreach ($list as $counter => $_item) {
        ?>
        <li id="counter_<?php echo $counter ?>">
            <?php echo $_item['caption'] ?>
            &nbsp; &nbsp;
            <span id="info_<?php echo $counter ?>"></span>
        </li>
        <?php
    }
    ?>
    <li id="complete" >
        Генерация файла завершена.
        <span id="info_complete"></span>
    </li>
</ul>
<button id="start_button" onclick="step()">запустить</button>

<script>
    var urls_array=[];
    var url_add="";
    var step_now=0;
    var max_step=<?php echo count($list) ?>;
<?php foreach ($list as $counter => $_item) { ?>urls_array[<?php echo $counter ?>]="<?php echo $_item['url'] ?>"; <?php echo "\r\n" ?><?php } ?>

    function get_data(url){
        $.getJSON(url+url_add, {},
        function(data){
            url_add="";
            if (data.status=="next"){
                $("#counter_"+step_now).css("font-weight","normal");
                $("#info_"+step_now).html("");
                step_now++;
                if ((data.text) && (step_now==max_step)){
                    $("#info_complete").html(data.text);
                };
                step();
            }
            if (data.status=="this"){
                if (data.text){
                    $("#info_"+step_now).html("["+data.text+"]");
                };
                if (data.add_url){
                    url_add=data.add_url;
                }
                step();
            }
        });
    }

    function step(){
        if (step_now==0){
            $("#start_button").hide();
        };
        $("#counter_"+step_now).css("font-weight","bold");
        if (step_now==max_step){
            $("#counter_"+step_now).css("font-weight","normal");
            $("#complete").css("font-weight","bold");
        }else{
            get_data(urls_array[step_now]);
        }

    }
</script>

<br><br>
<a href="?skip_download=1">Пропустить этап скачивания</a>
<br><br>
<a href="?skip_download=0">Не пропускать этап скачивания</a>