<template>
    <div class="container">

        <h1>Employee</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="First Name" v-model="first_name">
                    <span v-if="errors" style="color:red">{{errors.first_name}}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="last Name" v-model="last_name">
                    <span v-if="errors" style="color:red">{{errors.last_name}}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <!-- <input type="text" class="form-control" placeholder="Company" v-model="company"> -->
                    <select class="browser-default custom-select" v-model="company">
                        <template v-for="value in companyList">
                            <option v-bind:value="value.id">{{value.name}}</option>
                        </template>
                    </select>
                    <span v-if="errors" style="color:red">{{errors.company}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email" v-model="email">
                    <span v-if="errors" style="color:red">{{errors.email}}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" onfocus="this.value=''" v-model="password">
                    <span v-if="errors" style="color:red">{{errors.password}}</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Phone" v-model="phone">
                    <span v-if="errors" style="color:red">{{errors.phone}}</span>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-primary" v-on:click="addEmployee()">
            <template v-if="employee_id == 0">
                Save
            </template>
            <template v-else>
                Update
            </template>
            </button>
        <template v-if="employee_id > 0">
            <button type="button" class="btn btn-primary" v-on:click="clearForm()">Add</button>
        </template>
        <a :href="'/companies'" target="_blank">
            <button type="button" class="btn btn-primary" style="float:right;">Company List</button>
        </a>

        <div>&nbsp;</div>
        <template >
            <div class="table-responsive">
                <table id="empTable" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">edit</th>
                            <template v-if="userType == 1">
                                <th class="text-center">delete</th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in targetList">
                            <td>{{item.first_name}} {{item.last_name}}</td>
                            <td>{{item.email}}</td>
                            <td>{{item.company_name}}</td>
                            <td>{{item.phone}}</td>

                            <td v-if="userName == item.id">
                                <center>
                                    <button type="button" id="btnAddCard" class="btn btn-info btn-sm" v-on:click="getEditdata(item.id);">edit</button>
                                </center>
                            </td>
                            <td v-else-if="userType == 1">
                                <center>
                                    <button type="button" id="btnAddCard" class="btn btn-info btn-sm" v-on:click="getEditdata(item.id);">edit</button>
                                </center>
                            </td>
                            <td v-else></td>
                            <template v-if="userType == 1">
                                <td>
                                    <center><button type="button" id="btnAddCard" class="btn btn-danger btn-sm" v-on:click="delEmployee(item.id);">delete</button></center>
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
                
                auth_user_id: $('#_auth_id').val(),

                first_name : '',
                last_name : '',

                company : '',
                email : '',

                password : '',
                phone : '',

                employee_id : 0,

                targetList : {},

                companyList : {},
                company_selected : '',

                errors : {}
            }

        },
        created(){
            this.getEmployee();
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

            clearForm(){
                this.first_name = '';
                this.last_name = '';
                this.company = '';
                this.email ='';
                this.password = '';
                this.phone = '';
                this.employee_id = 0;
            },

            getEditdata(id){

                var obj = this.targetList.find(function (obj) { 
                    return obj.id === id;
                });

                    this.first_name = obj.first_name;
                    this.last_name = obj.last_name;
                    this.company = obj.company_id;
                    this.email = obj.email;
                    this.password = obj.password;
                    this.phone = obj.phone;
                    this.employee_id = obj.id;
            },

            addEmployee(){

                var axiosUrl = "saveEmployee";
                var data = {
                    first_name : this.first_name,
                    last_name : this.last_name,
                    company : this.company,
                    email : this.email,
                    password : this.password,
                    phone : this.phone,
                    employee_id : this.employee_id,
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    alert('saved');
                        this.getEmployee();
                        this.first_name = '';
                        this.last_name = '';
                        this.company = '';
                        this.email ='';
                        this.password = '';
                        this.phone = '';
                        this.employee_id = '';

                }).catch(error => {
                    this.errors = error.response.data.errors;
                });
    
            },

            getEmployee(){

                var axiosUrl = "getEmployeeList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.targetList = response.data;
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
    
            },

            delEmployee(id){

                var axiosUrl = "delEmployee";
                var data = {
                    id : id,
                }

                let self = this;
                axios.post(axiosUrl, data).then(response => {
                    alert('deleted');
                    this.getEmployee();
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });
    
            },


            getCompany(){

                var axiosUrl = "getCompanyList";
                var data = {
                }

                let self = this;
                axios.get(axiosUrl, data).then(response => {
                    self.companyList = response.data;
                }).catch(error => {
                    self.errors = error.response.data.errors;
                });
    
            },

            // fetchArticles:function(page_url){


            //     let vm = this;
            //     page_url = page_url || 'articles'
            //     fetch(page_url)
            //         .then(res => res.json())
            //         .then(res =>{
            //             this.articles = res.data;
                       

            //         })
            //         .catch(err => this.articles ={title:'no post found!'});
                    
            // },
           
            // deleteArticle(id){
            //      if(confirm('Are your sure?')){ //not working
            //     var axiosUrl = "delte";
            //     this.article.id = id;
            //     var data = {
            //         Article : this.article,  
            //     }
            //     let self = this;
            //     axios.post(axiosUrl, data).then(response => {
            //          alert('DELETED!');
            //         this.fetchArticles();

            //     });
            //      }

            // },
            // addArticle(){
                
            //     //   this.articles.push(article);
            //     if(this.edit === false){
            //     var axiosUrl = "blog";
            //     var data = {
            //         Article : this.article,  
            //     }
            //     let self = this;
            //     axios.post(axiosUrl, data).then(response => {
            //         //  alert(JSON.stringify(data));
            //         alert('Added');
            //         this.fetchArticles();
            //     });
            //     }else{
            //         //update
            //     var axiosUrl = "update";
            //     this.article.id = id;
            //     var data = {
            //         Article : this.article,  
            //     }
            //     let self = this;
            //     axios.post(axiosUrl, data).then(response => {
            //         //  alert(JSON.stringify(data));
            //         alert('post updated!');
            //         this.fetchArticles();
            //     });

            //     }
            // },
            // editArticle(article){
            //     this.edit =true ;
            //     this.article.id = article.id;
            //     this.article.article_id = article.id;
            //     this.article.title = article.title;
            //     this.article.body = article.body;

                
            // }
        }
    };
</script>
