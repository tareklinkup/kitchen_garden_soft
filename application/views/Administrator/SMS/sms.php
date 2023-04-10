<div id="sms">
    <div class="row">
        <div class="col-md-5">
            <form v-on:submit.prevent="sendSms">
                <div class="form-group">
                    <label for="smsText">SMS Text</label>
                    <textarea class="form-control" id="smsText" v-model="smsText" v-on:input="checkSmsLength" style="height:100px;"></textarea>
                    <p style="display:none" v-bind:style="{display: smsText.length > 0 ? '' : 'none'}">{{ smsText.length }} | {{ smsLength - smsText.length }} Remains | Max: {{ smsLength }} characters</p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-xs pull-right" v-bind:style="{display: onProgress ? 'none' : ''}"> <i class="fa fa-send"></i> Send </button>
                    <button type="button" class="btn btn-primary btn-xs pull-right" disabled style="display:none" v-bind:style="{display: onProgress ? '' : 'none'}"> Please Wait .. </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Select All &nbsp; <input type="checkbox" v-on:click="selectAll"></th>
                            <th>Customer Code</th>
                            <th>Customer Name</th>
                            <th>Mobile</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody style="display:none" v-bind:style="{display: customers.length > 0 ? '' : 'none'}">
                        <tr v-for="customer in customers">
                            <td><input type="checkbox" v-bind:value="customer.Customer_Mobile" v-model="selectedCustomers" v-if="customer.Customer_Mobile.match(regexMobile)"></td>
                            <td>{{ customer.Customer_Code }}</td>
                            <td>{{ customer.Customer_Name }}</td>
                            <td><span class="label label-md arrowed" v-bind:class="[customer.Customer_Mobile.match(regexMobile) ? 'label-info' : 'label-danger']">{{ customer.Customer_Mobile }}</span></td>
                            <td>{{ customer.Customer_Address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>

<script>
    new Vue({
        el:'#sms',
        data(){
            return {
                customers:[],
                selectedCustomers: [],
                smsText: '',
                smsLength: 306,
                onProgress: false,
                regexMobile: /^01[13-9][\d]{8}$/
            }
        },
        created(){
            this.getCustomers();
        },
        methods:{
            getCustomers(){
                axios.get('/get_customers').then(res => {
                    this.customers = res.data.map(customer => {
                        customer.Customer_Mobile = customer.Customer_Mobile.trim();
                        return customer;
                    });
                })
            },
            selectAll(){
                let checked = event.target.checked;
                if(checked){
                    this.selectedCustomers = [...new Set(this.customers.map(v => v.Customer_Mobile))].filter(mobile => mobile.match(this.regexMobile));
                } else {
                    this.selectedCustomers = [];
                }
            },
            checkSmsLength(){
                if(this.smsText.length > this.smsLength){
                    this.smsText = this.smsText.substring(0, this.smsLength);
                }
            },
            sendSms(){
                if(this.selectedCustomers.length == 0){
                    alert('Select customer');
                    return;
                }

                if(this.smsText.length == 0){
                    alert('Enter sms text');
                    return;
                }

                let data = {
                    smsText: this.smsText,
                    numbers: this.selectedCustomers
                }

                this.onProgress = true;
                axios.post('/send_bulk_sms', data).then(res => {
                    let r = res.data;
                    alert(r.message);
                    this.onProgress = false;
                })
            }
        }
    })
</script>