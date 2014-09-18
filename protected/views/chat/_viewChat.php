<div class="message">
    <div class="idChat" style="display: none"><?php echo $data->idChat?></div>
    <div class="author"><?php echo (!empty($data->idUser0["lastFirstName"]) ? $data->idUser0["lastFirstName"] : $data->idUser0["login"])?></div>
    <div class="date"><?php echo $data->date?></div>
    <div class="text"><?php echo $data->text?></div>
</div>