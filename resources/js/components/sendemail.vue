<template>
    <div class="container">
        <h1>Send Email Notification</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="From Name" v-model="from_name">
                    <span v-if="errors" style="color:red">{{errors.from_name}}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="From Email" v-model="from_email">
                    <span v-if="errors" style="color:red">{{errors.from_email}}</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="to Name" v-model="to_name">
                    <span v-if="errors" style="color:red">{{errors.to_name}}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="to Email" v-model="to_email">
                    <span v-if="errors" style="color:red">{{errors.to_email}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Message" v-model="message">
                    <span v-if="errors" style="color:red">{{errors.message}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary" v-on:click="sendEmail()">send</button>
                <a :href="'/employees'" target="_blank">
                    <button type="button" class="btn btn-primary" style="float:right;">Employee List</button>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return {
             
                from_name : '',
                from_email : '',
                to_name : '',
                to_email : '',
                message : '',

                errors : {}
            }

        },
        created(){

        },
        mounted (){

        },

        beforeUpdate: function() {

        },

        updated: function(){
  
        },
       
        methods:{

            sendEmail(){

                var axiosUrl = "sendEmail";
                var data = {
                    from_name : this.from_name,
                    from_email : this.from_email,
                    to_name : this.to_name,
                    to_email : this.to_email,
                    message : this.message,
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    alert('Email Sent');
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });
    
            },
        }
    };
</script>
