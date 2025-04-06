<?php $this->load->view("partial/header"); ?>

<script  src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script  src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
<script  src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<!-- <script  src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script> -->
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">
<link rel="stylesheet" href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css">
<div class="card">
										<!--begin::Card header-->
										<div class="card-header border-0 pt-6">
											<!--begin::Card title-->
											<div class="card-title">
    
											</div>
											<!--begin::Card title-->
										</div>
										<!--end::Card header-->
										<!--begin::Card body-->
										<div class="card-body py-4">
                                        <table id="table" class="table table-striped table-row-bordered gy-5 gs-7" cellspacing="0" width="100%">
        <thead>
            <tr>
                
                <th>Code</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            foreach ($langdata as $key => $value) { 
            ?>
        <tr>
                <td><?= $key; ?></td>
                <td id="<?= $key; ?>" class="editable"><?= $value; ?></td>
                <td><button class="btn btn-primary" onclick="ai_trans('<?= $key; ?>')">AI Translate </button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
                                        </div>
                                        
</div>

<script src="<?site_url()?>assets/js/axios.min16.js"></script>
<script>
const urld = "<?php echo site_url() ?>language/update/<?= $code ?>/";
const updateField = (_id, data, callback) => {
    $.ajax({
        url: `${urld}${_id}`,
        data,
        type: 'POST',
        success: (data) => {
            callback(null);
        },
        error: (err) => {
            callback(err);
        }
    });
};
$(document).ready(function () {
    var table = $('#table').DataTable();
    $("#table tbody").on('click', '.editable', function () {
        var myCell = table.cell(this);
        console.log(myCell[0][0]['row']);
        var _id = myCell.context[0].aoData[myCell[0][0]['row']]._aData[0];
        console.log(_id);
        var column = myCell["0"][0].column;
        var field = myCell.context[0].aoColumns[column].sTitle;
        var data = myCell.data();
        if (data.search('<input') === -1) {
            myCell.data('<input type="text" id="input' + _id + '" value="' + data + '"/>');
            var input = document.getElementById(`input${_id}`);
            input.addEventListener("keyup", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                    var newData = {};
                    newData[field] = input.value;
                    updateField(_id, newData, (err) => {
                        if (err) alert(err);
                        else {
                            myCell.data(input.value);
                        }
                    });
                }
            })
        }
    })
});

function ai_trans(term){
    let text = term;
 result = text.replace("_", "");
const params = {
    to: ["ar"],
    from: "en",
    texts: [
        result
    ]
};

$.ajax({
    url: "https://api.lecto.ai/v1/translate/text",
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-API-Key": "MAKCZ99-FS3MPVV-JDS2VVG-ZZ83QPR" // Replace with your API key
    },
    data: JSON.stringify(params)
})
.done(function(response) {
 
    var l = document.getElementById(term);
for(var i=0; i<5; i++){
  l.click();
}
$('#input'+term).val(response.translations[0]['translated'][0]);
})
.fail(function(error) {
   show_feedback('error', ''+error.responseJSON.details.message+'' , '<?php lang('error') ?>');

    
    console.error("Error:", error);
});

}

</script>
<?php $this->load->view("partial/footer"); ?>