<div class="container">
    <h3><?php echo $title;?></h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                    if(count($result)==0){
                ?>
                <tr>
                    <td colspan="4"><?php echo $this->lang->line('no_record_found');?></td>
                </tr>   
                <?php
                    }
                    foreach($result as $key => $val){
                ?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=$val['code']?></td>
                    <td><?=$val['title']?></td>
                    <td><a href="#" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a> <a href="#" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>