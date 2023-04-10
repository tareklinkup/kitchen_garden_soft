
<div class="side-by-side clearfix">
  <div>
    <select id="ProID" data-placeholder="Product..." class="chosen-select" style="width:150px;" tabindex="2" onchange="Products()">
     <option value=""></option>
     <?php 
     $brunch=$this->session->userdata('BRANCHid');
     $querys = mysql_query("SELECT *  FROM tbl_product WHERE ProductCategory_ID = '$ProCat' AND Product_branchid='$brunch'");
     while($row = mysql_fetch_array($querys)){ 
      $proname = $row['Product_Name'];?>
      <option value="<?php  echo $row['Product_SlNo'] ?>"><?php echo $row['Product_Code'].' '.$row['Product_Name'] ?></option>
      <?php } ?>
    </select>
  </div>
</div>

<script type="text/javascript">
  var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"}
  }
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }
</script>