<?php
$brunch=$this->session->userdata('BRANCHid');
$query=mysql_query("SELECT * FROM tbl_company WHERE company_BrunchId='$brunch'");
$row=mysql_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
<title> </title>
<meta charset='utf-8'>
    <link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
</head>
<style type="text/css" media="print">
.hide{display:none}
</style>
<script type="text/javascript">
window.onload = async () => {
		await new Promise(resolve => setTimeout(resolve, 1000));
		window.print();
		window.close();
	}
</script>
<body style="background:none;">


      <table width="800px" align="center" style="margin-bottom:200px">
        <tr>
          <td align="right" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $row['Company_Logo_org']; ?>" alt="Logo" style="width:100px;" /></td>
          <td align="left" width="750">
            <div class="">
				<div style="text-align:center;" >
				<strong style="font-size:18px;"><?php echo $row['Company_Name']; ?></strong><br>
				<?php echo $row['Repot_Heading']; ?><br>
              </div>
			</div>
          </td>
        </tr>

        <tr>
            <td colspan="2"> 
                <table class="border" cellspacing="0" cellpadding="0" style="text-align:center;width:100%;">
                <thead>
                    <tr class="header">
                        <th style="width:10;text-align:center;%">SL NO</th>
                        <th style="width:15;text-align:center;%">Contractor Name</th>                                                               
                        <th style="width:15;text-align:center;%">Phone Number</th>                                                               
                        <th style="width:15;text-align:center;%">Address</th>                                                               
                        <th style="width:15;text-align:center;%">Entry Date</th>                                                               
                        <th style="width:15;text-align:center;%">Note</th>                                                                                                                                                                                           
                    </tr>
                </thead>
                <tbody>
                <?php 
				$brunch = $this->session->userdata('BRANCHid');
				$query = $this->db->query("select * from tbl_contractor where branch_id='$brunch'");
				$contractor = $query->result();
				$i = 1;
                foreach($contractor as $contractor){ ?>
                    <tr align="center">
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $contractor->contractor_name; ?></td>
                        <td><?php echo $contractor->phone; ?></td>
                        <td><?php echo $contractor->address; ?></td>
                        <td><?php echo $contractor->entry_date; ?></td>
                        <td><?php echo $contractor->note; ?></td>
                    </tr>
                <?php 
				}
				?> 
                </tbody>  
            </table> 
			</td>
			</tr>
            </table> 

<div class="provied">
  <span style="float:left;font-size:11px;">Software Provied By Link-Up Technology</span>
</div>
</body>
</html>

