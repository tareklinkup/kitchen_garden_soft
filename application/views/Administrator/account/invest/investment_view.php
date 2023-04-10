<style>
    .balance-section{
        width: 100%;
        min-height: 150px;
        background-color: #f0f1d3;
        border: 1px solid #cfcfcf;
        text-align: center;
        padding: 25px 10px;
        border-radius: 5px;
    }

    .balance-section h3{
        margin: 0;
        padding: 0;
    }

    .account-section{
        display: flex;
        border: 1px solid #cfcfcf;
        border-radius: 5px;
        overflow:hidden;
        margin-bottom: 20px;
    }

    .account-section h3{
        margin: 10px 0;
        padding: 0;
    }

    .account-section .col1{
        background-color: #247195;
        color: white;
        flex: 1;
        display: flex;
        align-items: center; 
    }
    .account-section .col2{
        background-color: #def1f8;
        flex: 2;
        padding: 10px;
        align-items: center; 
        text-align:center;
    }

    
</style>
<div id="cashView">
    <div class="row">

        <div class="col-md-4">
            <div class="balance-section">
                <i class="fa fa-bank fa-3x"></i>
                <h3>Investment Balance</h3>
                <?php $investment_balance = array_reduce($investment_account_summary, function($prev, $curr){ return $prev + $curr->balance;});?>
                <h1><?php echo $this->session->userdata('Currency_Name');?> <?php echo number_format($investment_balance, 2);?></h1>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 25px;">
        <?php foreach($investment_account_summary as $account){?>
        <div class="col-md-3">
            <div class="account-section">
                <div class="col1">
                    <i class="fa fa-dollar fa-3x"></i>
                </div>
                <div class="col2">
                    <?php echo $account->Acc_Code;?><br>
                    <?php echo $account->Acc_Name;?><br>
                    <h3><?php echo $this->session->userdata('Currency_Name');?> <?php echo $account->balance;?></h3>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
