<template>
<!--    创建申请表-->
  <div class="div1">
    <br>
    <span class="spannew">{{Name}}(编辑)</span>
  </div>
</template>

<script>
    export default {
        name: "Application",
        data(){
            return{
                Name:'',
                Time:new Date(),
                Type: '',
            }
        },
        methods:{
            getSpName:function () {
                //得到审批名称
                this.Name = this.$route.params.spName;
                console.log(this.Name);
            },
            getSpTime:function () {
                //审批时间
                this.Time = this.$route.params.spTime;
                console.log(this.Time);
            },
            getSptype:function () {
                //审批类型
                this.Type = this.$route.params.spType;
                console.log(this.Type);
            }
        },
        created() {
            this.getSpName();
            this.getSpTime();
            this.getSptype();
        },
        watch:{
            '$route'(to,from){
                this.getSpName();
                this.getSpTime();
                this.getSptype();
            }
        },
    }
</script>

<style scoped>
  @import "../../../common/css/list.css";
</style>
