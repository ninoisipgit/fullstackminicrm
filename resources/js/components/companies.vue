<template>
    <div class="container">
        <h1>Company</h1>

        <template v-if="userType == 1">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" v-model="name">
                    <span v-if="errors" style="color:red">{{errors.name}}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="email" v-model="email">
                    <span v-if="errors" style="color:red">{{errors.email}}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="website" v-model="website">
                    <span v-if="errors" style="color:red">{{errors.website}}</span>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <div class="form-group ">
                    <input type="file" name="logo" id="logo" ref="logo" v-on:change="handleLogoUpload()" class="btn btn-sm">
                    <span>Note: Maximum file size 2 mb</span>
                    <!-- <span class="help-block" v-if="errorForm.expensesFile">{{ errorForm.expensesFile[0] }}</span> -->
                    <!-- <span class="help-block" v-if="errorForm.file_path">{{ errorForm.file_path[0] }}</span> -->
                    <!-- <span class="help-block" v-if="errorForm.file_extension">{{ errorForm.file_extension[0] }}</span> -->
                </div>
            </div>
        </div>
        
            <button type="button" class="btn btn-primary" v-on:click="addCompany()">
                <template v-if="company_id == 0">
                    Save
                </template>
                <template v-else>
                    Update
                </template>
                </button>
            <template v-if="company_id > 0">
                <button type="button" class="btn btn-primary" v-on:click="clearForm()">Add</button>
            </template>
            <a :href="'/employees'" target="_blank">
                <button type="button" class="btn btn-primary" style="float:right;">Employee List</button>
            </a>
        </template>
        <div>&nbsp;</div>
            <a :href="'/send_email'" target="_blank">
                <button type="button" class="btn btn-info" style="float:right;">Send Email Notification</button>
            </a>
        <div>&nbsp;</div>
        <br>
        <template >
            <div class="table-responsive">
                <table id="empTable" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">website</th>
                            <th class="text-center">logo</th>
                            <!-- <th class="text-center">edit</th> -->
                            <template v-if="userType == 1">
                                <th class="text-center">delete</th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in targetList">
                            <td>{{item.name}}</td>
                            <td>{{item.email}}</td>
                            <td>{{item.website}}</td>
                            <td>
                                <center>
                                    <img width="50" height="50" v-bind:src="item.file_path" alt=" " />
                                </center>
                            </td>
                            <!-- <td>
                                <center>
                                    <button type="button" id="btnAddCard" class="btn btn-info btn-sm" v-on:click="getEditdata(item.id);">edit</button>
                                </center>
                            </td> -->
                            <template v-if="userType == 1">
                                <td>
                                    <center><button type="button" id="btnAddCard" class="btn btn-danger btn-sm" v-on:click="delCompany(item.id,item.file_path);">delete</button></center>
                                </td>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </div>
</template>

<script>
    export default{
        props: ['userName','userType'],
        data(){
            return {
             
                name : '',
                email : '',
                website : '',
                logo : '',

                company_id : 0,

                targetList : {},

                errors : {}
            }

        },
        created(){
            this.getCompany();

        },
        mounted (){
            $('#empTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
                "order" : [0,'desc']
            });
        },

        beforeUpdate: function() {
            $('#empTable').DataTable().destroy();

        },

        updated: function(){
            $('#empTable').DataTable( {
                "destroy" : true,
                "retrieve" : true,
                "select" : true,
                "ordering" : true,
                "order" : [0,'desc']
            });
        },
       
        methods:{
            handleLogoUpload(){
                this.logo = this.$refs.logo.files[0];
            },

            // clearForm(){
            //     this.first_name = '';
            //     this.last_name = '';
            //     this.company = '';
            //     this.email ='';
            //     this.password = '';
            //     this.phone = '';
            //     this.employee_id = 0;
            // },

            // getEditdata(id){

            //     var obj = this.targetList.find(function (obj) { 
            //         return obj.id === id;
            //     });

            //         this.first_name = obj.first_name;
            //         this.last_name = obj.last_name;
            //         this.company = obj.company;
            //         this.email = obj.email;
            //         this.password = obj.password;
            //         this.phone = obj.phone;
            //         this.employee_id = obj.id;
            // },

            addCompany(){

                let formData = new FormData();

                formData.append('logo', this.logo);
                formData.append('name', this.name);
                formData.append('website', this.website);
                formData.append('email', this.email);
                formData.append('company_id', this.company_id); 

                var axiosUrl = "saveCompany";
                let self = this;
                axios.post(axiosUrl,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        var data = response.data;
                        if(data.statusCode == 0){
                            alert("Successfully Saved!");
                            this.getCompany();
                        }else{
                            alert("Successfully Saved, but email notification failed");
                            this.getCompany();
                        }
                }).catch(function(error){
                    this.errors = error.response.data.errors;

                });
    
            },

            getCompany(){

                var axiosUrl = "getCompanyList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.targetList = response.data;
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
    
            },

            delCompany(id , filepath){

                var axiosUrl = "delCompany";
                var data = {
                    id : id,
                    filepath : filepath
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    alert('deleted');
                    this.getCompany();
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });
    
            },
        }
    };
</script>
