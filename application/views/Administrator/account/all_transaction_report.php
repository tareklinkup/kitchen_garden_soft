<style>
    .v-select {
        margin-top: -2.5px;
        float: right;
        min-width: 180px;
        margin-left: 5px;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        height: 25px;
    }

    .v-select input[type=search],
    .v-select input[type=search]:focus {
        margin: 0px;
    }

    .v-select .vs__selected-options {
        overflow: hidden;
        flex-wrap: nowrap;
    }

    .v-select .selected-tag {
        margin: 2px 0px;
        white-space: nowrap;
        position: absolute;
        left: 0px;
    }

    .v-select .vs__actions {
        margin-top: -5px;
    }

    .v-select .dropdown-menu {
        width: auto;
        overflow-y: auto;
    }

    #searchForm select {
        padding: 0;
        border-radius: 4px;
    }

    #searchForm .form-group {
        margin-right: 5px;
    }

    #searchForm * {
        font-size: 13px;
    }
</style>
<div id="cashTransactionReport">
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
        <div class="col-md-12">
            <form class="form-inline" id="searchForm" @submit.prevent="getTransactions">
                <div class="form-group">
                    <label>Transaction Type</label>
                    <select class="form-control" v-model="filter.transactionType">
                        <option value="">All</option>
                        <option value="received">Received</option>
                        <option value="paid">Payment</option>
                    </select>
                </div>

                <div class="form-group" style="display:none;" v-bind:style="{display: accounts.length > 0 ? '' : 'none'}">
                    <label>Accounts</label>
                    <v-select v-bind:options="accounts" v-model="selectedAccount" label="Acc_Name" @input="onChangeAccount"></v-select>
                </div>

                <div class="form-group">
                    <input type="date" class="form-control" v-model="filter.dateFrom">
                </div>

                <div class="form-group">
                    <input type="date" class="form-control" v-model="filter.dateTo">
                </div>

                <div class="form-group" style="margin-top: -5px;">
                    <input type="submit" value="Search">
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="display:none;" v-bind:style="{display: transactions.length > 0 ? '' : 'none'}">
        <div class="col-md-12" style="margin-top:15px;margin-bottom:15px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="printContent">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Tr. Id</th>
                            <th>Date</th>
                            <th>Tr. Type</th>
                            <th>Account Name</th>
                            <th>Description</th>
                            <th>Received Amount</th>
                            <th>Payment Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="transaction in transactions">
                            <td>{{ transaction.Tr_Id }}</td>
                            <td>{{ transaction.Tr_date }}</td>
                            <td>
                                <span v-if="transaction.Tr_Type == 'In Cash'">Cash Received</span>
                                <span v-else>Cash Payment</span>
                            </td>
                            <td>{{ transaction.Acc_Name }}</td>
                            <td>{{ transaction.Tr_Description }}</td>
                            <td style="text-align:right;">{{ transaction.In_Amount }}</td>
                            <td style="text-align:right;">{{ transaction.Out_Amount }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align:right;font-weight:bold;">Total</td>
                            <td style="text-align:right;font-weight:bold;">{{ transactions.reduce((p, c) => { return p + parseFloat(c.In_Amount) }, 0) }}</td>
                            <td style="text-align:right;font-weight:bold;">{{ transactions.reduce((p, c) => { return p + parseFloat(c.Out_Amount) }, 0) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row" style="display:none;padding-top: 15px;" v-bind:style="{display: transactions.length > 0 ? 'none' : ''}">
        <div class="col-md-12 text-center">
            No records found
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#cashTransactionReport',
        data() {
            return {
                filter: {
                    transactionType: '',
                    accountId: null,
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD')
                },
                accounts: [],
                selectedAccount: null,
                transactions: []
            }
        },
        created() {
            this.getAccounts();
            this.getTransactions();
        },
        methods: {
            getAccounts() {
                axios.get('/get_accounts').then(res => {
                    this.accounts = res.data;
                })
            },
            onChangeAccount() {
                if (this.selectedAccount == null || this.selectedAccount.Acc_SlNo == undefined) {
                    this.filter.accountId = null;
                    return;
                }
                this.filter.accountId = this.selectedAccount.Acc_SlNo;
            },
            getTransactions() {
                axios.post('/get_cash_transactions', this.filter).then(res => {
                    this.transactions = res.data;
                })
            },
            async print(){
                let dateText = "";
                if(this.filter.dateFrom != null && this.filter.dateTo != null){
                    dateText = `Statement from <strong>${this.filter.dateFrom}</strong>  to <strong>${this.filter.dateTo}</strong>`;
                }
                let printContent = `
                    <div class="container">
                        <h4 style="text-align:center">Cash Transaction Report</h4 style="text-align:center">
                        <div class="row">
                            <div class="col-xs-6 col-xs-offset-6 text-right">
                                ${dateText}
                            </div>
                        </div>
                    </div>
                    <div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#printContent').innerHTML}
							</div>
						</div>
                    </div>
                `;

                let printWindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
                printWindow.document.write(`
                    <?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
                `);

                printWindow.document.body.innerHTML += printContent;
                printWindow.focus();
                await new Promise(r => setTimeout(r, 1000));
                printWindow.print();
                printWindow.close();
            }
        }
    })
</script>