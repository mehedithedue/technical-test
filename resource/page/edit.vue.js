const Edit = {
    template: `
      <div class="row">
      <div class="col-md-8 mb-3">
        <h4 class="mb-3">Edit Document</h4>
        <form @submit.prevent="updateDocument">
          <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <input v-model="form.name" type="text" class="form-control" id="name" placeholder="Name">
            </div>
          </div>
          <div class="form-group row">
            <label for="category" class="col-sm-2 col-form-label">Category</label>
            <div class="col-sm-10">
              <select v-model="form.category" class="form-control" id="category"
                      required>
                <option v-for="category in categories" :key=category.id :value=category.id>
                  {{ category.category }}
                </option>
              </select>
            </div>
          </div>

          <div v-if="validationErrors" class="col-sm-10  offset-sm-2 p-2 alert-danger">{{ validationErrors }}</div>
          <div v-if="updateSuccess" class="col-sm-10  offset-sm-2 p-2 alert-success">Successfully Updated</div>

          <div class="mt-2 form-group row">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
      </div>`,
    data() {
        return {
            form: {
                name: null,
                category: null,
            },
            categories: [],
            validationErrors: undefined,
            updateSuccess: false,
        };
    },
    computed: {
        documentId() {
            return this.$route.params.documentId;
        }
    },
    mounted() {
        this.fetchDocument();
        this.fetchCategory();
    },

    methods: {
        setDocumentForm(document) {
            this.form.name = document.name;
            this.form.category = document.category_id
        },
        async fetchDocument() {
            try {
                const res = await axios.get(`/src/show-document`, {params: {document_id: this.documentId}});
                this.setDocumentForm(res.data.data)
            } catch (error) {
                this.validationErrors = error.response.data.message
            }
        },
        async fetchCategory() {
            try {
                const res = await axios.get(`/src/category`);
                this.categories = res.data.data;
            } catch (error) {
                this.validationErrors = error.response.data.message
            }
        },
        async updateDocument() {
            try {
                const res = await axios.post(`/src/document-edit`, this.form, {params: {document_id: this.documentId}});
                this.validationErrors = undefined
                this.updateSuccess = true;
                setTimeout(function () {
                    this.$router.push({name: 'home'})
                }.bind(this), 500);
            } catch (error) {
                this.validationErrors = error.response ? error.response.data.message : error;
            }
        },
    },
};