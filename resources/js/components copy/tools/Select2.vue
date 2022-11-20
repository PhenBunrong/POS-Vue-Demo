<template>
    <select class="form-control select2">
        <slot></slot>
    </select>
</template>

<script>
    import Select2 from "select2";

    export default {
        props:['options' , 'value'],

        mounted(){
            let vm = this;
            $(this.$el).select2({
                theme: 'bootstrap4', 
                data: this.options
            })

            .val(this.value)
            .trigger('change')
            .on('change' , function(){
                vm.$emit('input', this.value);
            });
        },  
        watch: { 
            value: function (value){
                // update value
                $(this.$el).val(value).trigger('change');
            },
            options: function(options){
                // update options
                $(this.$el).select2({ data: options });
            }
        },
        destroyed: function(){
            $(this.$el).off().select2('destroy');
        }
    }
</script>
