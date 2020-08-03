<template>
    <label id="thumbnail" class=''>
        <input type="file" @change="onFileSelected">
        <img src="../../assets/camera.svg" alt="Selecione uma imagem"/>
        <button @click="onUpload">Upload</button>
    </label>
</template>

<script>
export default {
    data(){
        return{
            selectedFile: null
        }
    },
    methods:{
        onFileSelected(event){
            this.selectedFile = event.target.file[0];
        },
        onUpload(){
            
            const formData = new FormData();

            formData.append('image', this.selectedFile, this.selectedFile.name);

            this.axios.post('http://localhost:8000/', formData)
                .then(response => {
                  
                })
        }
    }
}
</script>