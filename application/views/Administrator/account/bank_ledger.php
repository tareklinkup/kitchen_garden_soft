<style>
    .v-select{
		margin-bottom: 5px;
        float: right;
        min-width: 150px;
        margin-left: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
        height: 23px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
    #bankTransactionReport label{
        font-size: 13px;
    }
    #bankTransactionReport select{
        border-radius: 3px;
        padding: 0px;
    }
    #bankTransactionReport .form-group{
        margin-right: 5px;
    }
    #bankTransactionReport .search-button{
        margin-top: -6px;
    }
    #transactionsTable th{
        text-align: center;
    }
</style>
<div id="bankTransactionReport">
    <div class="row" style="border-bottom: 1px solid #ccc;margin-bottom: 15px;">
        <div class="col-md-12">
            <form class="form-inline" @submit.prevent="getTransactions">
                <div class="form-group">
                    <label>Account</label>
                    <v-select v-bind:options="computedAccounts" v-model="selectedAccount" label="display_text" @input="resetData"></v-select>
                </div>

                <div class="form-group">
                    <label>Date From</label>
                    <input type="date" class="form-control" v-model="filter.dateFrom" @change="resetData">
                </div>

                <div class="form-group">
                    <label>to</label>
                    <input type="date" class="form-control" v-model="filter.dateTo" @change="resetData">
                </div>

                <div class="form-group">
                    <input type="submit" value="search" class="search-button">
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="display:none;" v-bind:style="{display: showTable ? '' : 'none'}">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="reportContent">
                <table class="table table-bordered table-condensed" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Description</th>
                            <th>Note</th>
                            <th>Deposit</th>
                            <th>Withdraw</th>
                            <th>Balance</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="5" style="text-align:left;">Previous Balance</td>
                            <td style="text-align:right;">{{ previousBalance }}</td>
                        </tr>
                        <tr v-for="(transaction, sl) in transactions">
                            <td style="text-align:left;">{{ transaction.transaction_date }}</td>
                            <td style="text-align:left;">{{ transaction.description }}</td>
                            <td style="text-align:left;">{{ transaction.note }}</td>
                            <td style="text-align:right">{{ transaction.deposit }}</td>
                            <td style="text-align:right">{{ transaction.withdraw }}</td>
                            <td style="text-align:right">{{ transaction.balance }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#bankTransactionReport',
        data(){
            return {
                accounts: [],
                selectedAccount: null,
                previousBalance: 0.00,
                transactions: [],
                filter: {
                    accountId: null,
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD'),
                    ledger: true,
                },
                showTable: false
            }
        },
        computed:{
            computedAccounts(){
                let accounts = this.accounts.filter(account => account.status == '1');
                return accounts.map(account => {
                    account.display_text = `${account.account_number} (${account.bank_name})`;
                    return account;
                })
            }
        },
        watch: {
            selectedAccount(account) {
                this.filter.accountId = account?.account_id ?? null;
            }
        },
        created(){
            this.getAccounts();
        },
        methods: {
            getAccounts(){
                axios.get('/get_bank_accounts')
                .then(res => {
                    this.accounts = res.data;
                })
            },

            getTransactions(){
                if(this.selectedAccount == null){
                    alert('Select account');
                    return;
                }

                axios.post('/get_all_bank_transactions', this.filter)
                .then(res => {
                    this.previousBalance = res.data.previousBalance;
                    this.transactions = res.data.transactions;
                    this.showTable = true;
                })
                .catch(error => {
                    if(error.response){
                        alert(`${error.response.status}, ${error.response.statusText}`);
                    }
                })
            },

            resetData(){
                this.previousBalance = 0;
                this.transactions = [];
            },

            async print(){
                let accountText = '';
                if(this.selectedAccount != null){
                    accountText = `<strong>Account: </strong> ${this.selectedAccount.account_number} (${this.selectedAccount.bank_name})<br>`;
                }

                dateText = '';
                if(this.filter.dateFrom != '' && this.filter.dateTo != ''){
                    dateText = `Statement from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>`;
                }
                
                let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Bank Transaction Report</h4 style="text-align:center">
                        <div class="row">
                            <div class="col-xs-6">${accountText}</div>
                            <div class="col-xs-6 text-right">${dateText}</div>
                        </div>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				printWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

                printWindow.document.head.innerHTML += `
                    <style>
                        #transactionsTable th{
                            text-align: center;
                        }
                    </style>
                `;
				printWindow.document.body.innerHTML += reportContent;

				printWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                printWindow.print();
                printWindow.close();
            }
        }
    })
</script>
