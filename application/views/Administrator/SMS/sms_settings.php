<style>
    #smsSettings label {
        font-size: 13px;
    }
</style>
<div id="smsSettings">
    <form @submit.prevent="saveSettings">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Gateway 1</label>
                    <div class="col-md-8">
                        <input type="checkbox" v-model="settings.sms_enabled" true-value="gateway1" false-value="false">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">API Key</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.api_key">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">URL</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.url">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Bulk URL</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.bulk_url">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Sender Id</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.sender_id">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">SMS Type</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.sms_type">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Gateway 2</label>
                    <div class="col-md-8">
                        <input type="checkbox" v-model="settings.sms_enabled" true-value="gateway2" false-value="false">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">URL</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.url_2">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Bulk URL</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.bulk_url_2">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">User Id</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.user_id">
                    </div>
                </div>
                
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Sender Id</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.sender_id_2">
                    </div>
                </div>
                
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Country Code</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.country_code">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" v-model="settings.password">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Sender Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.sender_name">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Sender Phone</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="settings.sender_phone">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="col-md-8 col-md-offset-4">
                        <input type="submit" value="Save" class="btn btn-success btn-sm">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>

<script>
    new Vue({
        el: '#smsSettings',
        data() {
            return {
                settings: {
                    sms_enabled: 'false',
                    api_key: '',
                    url: '',
                    bulk_url: '',
                    url_2: '',
                    bulk_url_2: '',
                    sms_type: '',
                    sender_id: '',
                    sender_id_2: '',
                    user_id: '',
                    password: '',
                    country_code: '',
                    sender_name: '',
                    sender_phone: ''
                }
            }
        },
        created() {
            this.getSettings();
        },
        methods: {
            getSettings() {
                axios.get('/get_sms_settings').then(res => {
                    if (res.data != null) {
                        this.settings = res.data;
                    }
                })
            },
            saveSettings() {
                axios.post('/save_sms_settings', this.settings)
                    .then(res => {
                        let r = res.data;
                        alert(r.message);
                    })
                    .catch(error => alert(error.response.statusText))
            }
        }
    })
</script>