<template>
        <div>
                     <notifications group="foo" 
      position="bottom right" 
      classes="vue-notification error"/> 
           <div class="row">
               <div class="col-3">
               <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button @click="testAffich.testfamille = true;testAffich.testSolde =false;testAffich.testTVA = false;testAffich.testStatus = false;testAffich.testTypePaiement = false" class="btn btn-primary mb-3 shadawButton">Famille article </button>
                <button @click="testAffich.testTVA = true;testAffich.testSolde =false;testAffich.testfamille = false;testAffich.testStatus = false;testAffich.testTypePaiement = false" class="btn btn-primary mb-3 shadawButton">TVA </button>
                <button @click="testAffich.testStatus = true;testAffich.testSolde =false;testAffich.testfamille = false;testAffich.testTVA=false;testAffich.testTypePaiement = false" class="btn btn-primary mb-3 shadawButton ">Statut </button>
                <button @click="testAffich.testTypePaiement = true;testAffich.testSolde =false;testAffich.testfamille = false;testAffich.testTVA=false;testAffich.testStatus = false" class="btn btn-primary mb-3 shadawButton ">Type paiement</button>
                <button @click="testAffich.testSolde = true;testAffich.testTypePaiement = false;testAffich.testfamille = false;testAffich.testTVA=false;testAffich.testStatus = false" class="btn btn-primary mb-3 shadawButton ">Solde Initial</button>
                </div>
               </div>
                <div class="col">
                    <div v-if="testAffich.testfamille"> 
                    
                    <div class="row">
                    <input class="mr-4" v-model="famille_article.libelle_famille" type="text"  placeholder="Entrez famille article"><button @click="addFamille" class="btn btn-success">Ajouter </button>
                    </div>
                    <div class="row">
                       <table class="table table-bordered tableau">
                        <thead>
                            <tr>
                            <th>Catégorie</th>
                            <th>Option</th>
                            </tr>                           
                        </thead>
                        <tbody>                     
                            <tr v-for="famille in famille_articles" :key="famille.id_famille">
                            <th>{{famille.libelle_famille}}</th>      
                            <th><a @click="deleteFamille(famille)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                            </tr>
                        </tbody>
                       </table>
                     </div>  
                     </div>
                    <div v-if="testAffich.testTVA">                     
                    <div class="row">
                    <input   v-model="tva.taux_tva"   class="mr-4" type="text"  placeholder="Entrez Taux TVA"><button @click="addTva"  class="btn btn-success">Ajouter </button>
                    </div>
                    <div class="row">
                       <table class="table table-bordered tableau">
                        <thead>
                            <tr>
                            <th>Taux TVA</th>
                            </tr>
                        </thead>
                        <tbody>                     
                            <tr v-for="tva in tvas" :key="tva.id_tva">
                            <th>{{tva.taux_tva}}</th>      
                            <th><a @click="deleteTva(tva)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                            </tr>
                        </tbody>
                       </table>
                     </div>  
                     </div>
                     <div v-if="testAffich.testStatus"> 
                    <div class="row">
                        <div class="col">
                    <input v-model="statu.type_status"  type="text"  placeholder="Entrez Statut">
                    </div>
                    <div class="col">
                    <input type="color" id="html5colorpicker" style="height: 37px;width:150px" v-model="statu.colorStatu">
                    </div>
                    <div class="col">
                     <button @click="addStatu" class="btn btn-success">Ajouter </button>
                     </div>
                   </div>
                
                    




                    
                    <div class="row">
                       <table class="table table-bordered tableau">
                        <thead>
                            <tr>
                            <th>Status documents</th>
                            </tr>
                        </thead>
                        <tbody>                     
                            <tr v-for="statu in status" :key="statu.id_status">
                            <th>{{statu.type_status}}</th>      
                            <th v-if="statu.type_status != 'validé' && statu.type_status != 'annulée'" ><a @click="deleteStatu(statu)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                            </tr>
                        </tbody>
                       </table>
                     </div>  
                     </div>


                      <div v-if="testAffich.testTypePaiement"> 
                    <div class="row">
                        <div class="col">
                    <input v-model="typePaiement.type_paiement"  type="text"  placeholder="Entrez Type paiement">
                    </div>
                    <div class="col">
                     <button @click="addTypePaiement" class="btn btn-success">Ajouter </button>
                     </div>
                   </div>             
                    <div class="row">
                       <table class="table table-bordered tableau">
                        <thead>
                            <tr>
                            <th>Type de paiement</th>
                            </tr>
                        </thead>
                        <tbody>                     
                            <tr v-for="typePaiement in typePaiements" :key="typePaiement.id_type_paiement">
                            <th>{{typePaiement.type_paiement}}</th>      
                            <th v-if="typePaiement.type_paiement != 'cheque'"><a @click="deleteTypePaiement(typePaiement)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                            </tr>
                        </tbody>
                       </table>
                     </div>  
                     </div>


                      <div v-if="testAffich.testSolde"> 
                    <div class="row">
                        <div class="col">
                    <input v-model="solde.solde_init"  type="text"  placeholder="Entrez Solde initial">
                    <input v-model="solde.annee_init"  type="text"  placeholder="Entrez Annee initial">
                    </div>
                    <div class="col">
                     <button @click="addSolde" class="btn btn-success">Ajouter </button>
                     </div>
                   </div>             
                    <div class="row">
                       <table class="table table-bordered tableau">
                        <thead>
                            <tr>
                            <th>Solde initial</th>
                            <th>Annee </th>
                            </tr>
                        </thead>
                        <tbody>                     
                            <tr v-for="solde in soldes" :key="solde.id_solde">
                            <th>{{solde.solde_init}}</th>      
                            <th>{{solde.annee_init}}</th>      
                            <th ><a @click="deleteSolde(solde)" class="btn btn-danger"><i class="fas fa-trash-alt d-inline-block"></i></a></th>
                            </tr>
                        </tbody>
                       </table>
                     </div>  
                     </div>
                </div>
            </div>        


           </div>
       


</template>

<script>
    export default {
  
  data : () => ({
      colorStatu:"#ff0000",
        testAffich:{
            testfamille:true,
            testTVA:false,
            testStatus:false,
            testTypePaiement:false,
            testSolde:false,
        },
        famille_article:{
            id_famille : 0,
            libelle_famille : ""
        },
        famille_articles:[],

        tva:{
            id_tva : 0,
            taux_tva : ""
        },
        tvas:[],

        statu:{
            id_status : 0 ,
            type_status : "",
            colorStatu : "",
        },
        status:[],
         typePaiement:{
            id_type_paiement: 0,
            type_paiement: "",
          },
          typePaiements: [],
          solde:{
              id_solde:0,
              solde_init:"",
          },
          soldes:[],
          add:false,
          }),
    
        
          mounted(){
                this.getfamilles();
                this.getTvas();
                this.getStatus();
                this.getTypePaiement();
                this.getSoldes();
          },
        methods:{
                //-------------------------------------- famille
            addFamille(){
                  axios.post('/addFamille',this.famille_article).then(response => {     
                      this.getfamilles();    
                    console.log('famille Bien ajouter !');
                  });
            },
 
        getfamilles(){
                axios.get('/getfamilles')
                .then((response) => {
                 // console.log('shit');
                    this.famille_articles = response.data.famille_articles;
                    
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
                       deleteFamille(famille){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deletefamille/'+famille.id_famille).then(
                                        response => {
                                
                                            this.getfamilles();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre categorie a été supprimé',
                        'success'
                        )
                        }
                        })
                        },
            //-------------------------------------- tva 
                addTva(){
                  axios.post('/addTva',this.tva).then(response => {     
                     this.getTvas();
                    console.log('famille Bien ajouter !');
                  });
            },
                getTvas(){
                axios.get('/getTvas')
                .then((response) => {
                  //console.log(response.data);
                    this.tvas= response.data.tvas;
                  //  console.log(this.tvas);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
                                 deleteTva(tva){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deleteTva/'+tva.id_tva).then(
                                        response => {
                                
                                            this.getTvas();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre tva a été supprimé',
                        'success'
                        )
                        }
                        })
                        },
                        //-------------------------------------- status
            addStatu(){
             if(this.typePaiement.type_paiement.toLowerCase().indexOf("validé")> -1 || this.typePaiement.type_paiement.toLowerCase().indexOf("annulée")> -1 ){
                                 this.$notify({
                                      group: 'foo',
                                      title: 'error',
                                      text: 'statut déja exist',
                                      duration: 1500,
                                    });
               } else {
                console.log('-------- color ')
                console.log(this.colorStatu);
                axios.post('/addStatu',this.statu).then(response => {     
                    this.getStatus();
                    console.log('status Bien ajouter !');
                  });}
            },
            getStatus(){
                
                axios.get('/getStatus')
                .then((response) => {
                  console.log(response.data);
                    this.status= response.data.status;
                   // console.log(this.tvas);
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
                    deleteStatu(statu){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deleteStatu/'+statu.id_status).then(
                                        response => {
                                            console.log('statut bien supprimer');
                                            this.getStatus();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre statut a été supprimé',
                        'success'
                        )
                        }
                        })
                        },

// type paiement
                        addTypePaiement(){
                           if(this.typePaiement.type_paiement.toLowerCase().indexOf("cheque")> -1 || this.typePaiement.type_paiement.toLowerCase().indexOf("chèque")> -1 || this.typePaiement.type_paiement.toLowerCase().indexOf("chéque")> -1 ){
                                 this.$notify({
                                      group: 'foo',
                                      title: 'error',
                                      text: 'cheque déja exist',
                                      duration: 1500,
                                    });
                           } else {
                           console.log('type paiement : '+this.typePaiement.type_paiement);
                                axios.post('/addTypePaiement',this.typePaiement).then(response => {     
                            this.getTypePaiement();
                            console.log('Type Paiement Bien ajouter !');
                                });}
                        },
                        getTypePaiement(){
                            axios.get('/getTypePaiement')
                            .then((response) => {                        
                                this.typePaiements= response.data.listeTypePaiments;
                            })
                            .catch(() => {
                                console.log('handle server error from here');
                            });
          },
              deleteTypePaiement(typePaiement){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deleteTypePaiement/'+typePaiement.id_type_paiement).then(
                                        response => {
                                
                                           this.getTypePaiement();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre Type paiement a été supprimé',
                        'success'
                        )
                        }
                        })
                        },


                //------------------solde

                     addSolde(){
                  axios.post('/addSolde',this.solde).then(response => {     
                      this.getSoldes();    
                    console.log('famille Bien ajouter !');
                  });
            },
 
        getSoldes(){
                axios.get('/getSoldes')
                .then((response) => {
                  console.log('shit');
                    this.soldes = response.data.soldes;
                  console.log(this.soldes.length)  
                  if(this.soldes.length !=0){
                      this.add=false;
                  }
                  else{
                      this.add=true;
                  }
                  
                })
                .catch(() => {
                    console.log('handle server error from here');
                });
          },
                       deleteSolde(solde){


                        this.$swal({
                        title: 'Etes-vous sur?',
                        text: "Vous ne serez pas capable de revenir a cela!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui, supprimez-le!'
                                                }).then((result) => {
                        if (result.value) {
                            axios.delete('/deleteSolde/'+solde.id_solde).then(
                                        response => {
                                
                                            this.getSoldes();
                                        });
                        this.$swal(
                        'Supprimé!',
                        'Votre categorie a été supprimé',
                        'success'
                        )
                        }
                        })
                        },




},
    }
</script>
<style scoped>
    .shadawButton:hover {
  box-shadow: 1px 1px 1px 1px #888888;
    }
    .tableau{
    margin-top: 30px;
    }
</style>