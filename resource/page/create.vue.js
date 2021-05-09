const Create = {
    template: `
      <div class="row">
      <div class="col-md-8 mb-3">
        <h4 class="mb-3">Create New Document</h4>
        <form @submit.prevent="createDocument">
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
          <div v-if="createdSuccess" class="col-sm-10  offset-sm-2 p-2 alert-success">Successfully Created</div>

          <div class="mt-2 form-group row">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Create Document</button>
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
            createdSuccess: false,
        };
    },
    computed: {
        documentId() {
            return this.$route.params.documentId;
        }
    },
    mounted() {
        this.fetchCategory();
    },

    methods: {
        resetDocumentForm() {
            this.form.name = null;
            this.form.category = null
        },
        async fetchCategory() {
            try {
                const res = await axios.get(`/src/category`);
                this.categories = res.data.data;
            } catch (error) {
                this.validationErrors = error.response.data.message
            }
        },
        async createDocument() {
            this.createdSuccess = false;
            try {
                const res = await axios.post(`/src/document-create`, this.form);
                this.resetDocumentForm();
                this.validationErrors = undefined;
                this.createdSuccess = true;
            } catch (error) {
                this.validationErrors = error.response ? error.response.data.message : error;
            }
        },
    },
};