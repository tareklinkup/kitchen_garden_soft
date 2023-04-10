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
    #loanTransactionReport label{
        font-size: 13px;
    }
    #loanTransactionReport select{
        border-radius: 3px;
        padding: 0px;
    }
    #loanTransactionReport .form-group{
        margin-right: 5px;
    }
    #loanTransactionReport .search-button{
        margin-top: -6px;
    }
    #transactionsTable th{
        text-align: center;
    }
</style>
<div id="loanTransactionReport">
    <div class="row" style="border-bottom: 1px solid #ccc;margin-bottom: 15px;">
        <div class="col-md-12">
            <form class="form-inline" @submit.prevent="getTransactions">
                <div class="form-group">
                    <label>Account</label>
                    <v-select v-bind:options="computedAccounts" v-model="selectedAccount" label="display_text" @input="resetData"></v-select>
                </div>

                <div class="form-group">
                    <label>Transaction Type</label>
                    <select class="form-control" v-model="filter.transactionType" @change="resetData">
                        <option value="">All</option>
                        <option value="Receive">Receive</option>
                        <option value="Profit">Profit</option>
                        <option value="Payment">Payment</option>
                    </select>
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

    <div class="row" style="display:none;" v-bind:style="{display: transactions.length > 0 ? '' : 'none'}">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="reportContent">
                <table class="table table-bordered table-condensed" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Description</th>
                            <th>Transaction Date</th>
                            <th>Account Code</th>
                            <th>Account Name</th>
                            <th>Note</th>
                            <th>Receive</th>
                            <th>Profit</th>
                            <th>Payment</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(transaction, sl) in transactions">
                            <td style="text-align:right">{{ sl + 1}}</td>
                            <td style="text-align:left;">{{ transaction.description }}</td>
                            <td>{{ transaction.transaction_date }}</td>
                            <td>{{ transaction.Acc_Code }}</td>
                            <td>{{ transaction.Acc_Name }}</td>
                            <td>{{ transaction.note }}</td>
                            <td style="text-align:right">{{ transaction.receive }}</td>
                            <td style="text-align:right">{{ transaction.profit }}</td>
                            <td style="text-align:right">{{ transaction.payment }}</td>
                        </tr>
                    </tbody>

                    <tfoot>
                        <tr style="font-weight:bold;">
                            <td colspan="6" style="text-align:right;">Total &nbsp;</td>
                            <td style="text-align:right;">{{ transactions.reduce((prev, curr) => { return prev + parseFloat(curr.receive)}, 0) }}</td>
                            <td style="text-align:right;">{{ transactions.reduce((prev, curr) => { return prev + parseFloat(curr.profit)}, 0) }}</td>
                            <td style="text-align:right;">{{ transactions.reduce((prev, curr) => { return prev + parseFloat(curr.payment)}, 0) }}</td>
                        </tr>
                    </tfoot>
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
        el: '#loanTransactionReport',
        data(){
            return {
                accounts: [],
                selectedAccount: null,
                transactions: [],
                filter: {
                    accountId: null,
                    transactionType: '',
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD')
                }
            }
        },
        computed:{
            computedAccounts(){
                let accounts = this.accounts;
                return accounts.map(account => {
                    account.display_text = `${account.Acc_Code} - ${account.Acc_Name}`;
                    return account;
                })
            }
        },
        created(){
            this.getAccounts();
        },
        methods: {
            getAccounts(){
                axios.get('/get_investment_accounts')
                .then(res => {
                    this.accounts = res.data;
                })
            },

            getTransactions(){
                if(this.selectedAccount != null){
                    this.filter.accountId = this.selectedAccount.Acc_SlNo;
                } else {
                    this.filter.accountId = null;
                }

                axios.post('/get_all_investment_transactions', this.filter)
                .then(res => {
                    this.transactions = res.data;
                })
                .catch(error => {
                    if(error.response){
                        alert(`${error.response.status}, ${error.response.statusText}`);
                    }
                })
            },

            resetData(){
                this.transactions = [];
            },

            async print(){
                let accountText = '';
                if(this.selectedAccount != null){
                    accountText = `<strong>Account: </strong> ${this.selectedAccount.Acc_Code} - ${this.selectedAccount.Acc_Name}<br>`;
                }

                typeText = '';
                if(this.filter.transactionType != ''){
                    typeText = `<strong>Transaction Type: </strong> ${this.filter.transactionType}`;
                }

                dateText = '';
                if(this.filter.dateFrom != '' && this.filter.dateTo != ''){
                    dateText = `Statement from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>`;
                }
                let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Investment Transaction Report</h4 style="text-align:center">
                        <div class="row">
                            <div class="col-xs-6">${accountText} ${typeText}</div>
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
