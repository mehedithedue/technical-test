const Home = {
    template: `
      <div>
      <div class="row">
        <div class="col-md-5 mb-3">
          <h4 class="mb-3">Select Document Category</h4>
          <select v-model="category" @change="fetchDocumentOnCategory" class="custom-select d-block w-100" id="category"
                  required>
            <option v-for="category in categories" :key=category.id :value=category.id>
              {{ category.category }}
            </option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Document List</h4>
          <ul class="list-group mb-3">
            <li v-for="document in documents" :key=document.id
                class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6>{{ document.name }} </h6>
                <span class="text-muted mt-3">Created Date : {{ document.created_at || formateDate }}</span>
              </div>
              <span class="text-white">
                <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                  <router-link :to="{name: 'document.edit', params: {documentId: document.id}}"
                               class="btn btn-primary btn-sm">Edit</router-link>
                  <button type="button" @click="deleteDocument(document)" class="btn btn-danger">Delete</button>
                </div>
               </span>
            </li>
          </ul>
          <div v-if="errors" class="col-sm-10  offset-sm-2 p-2 alert-danger">{{ errors }}</div>
        </div>
      </div>
      </div>`,
    data() {
        return {
            category: undefined,
            categories: [],
            documents: [],
            errors: undefined,
        };
    },
    mounted() {
        this.fetchCategory();
    },
    filters: {
        formateDate: function (value) {
            var date = new Date(value);
            return date.toLocaleDateString("en-US");
        }
    },
    methods: {
        async fetchCategory() {
            try {
                const res = await axios.get(`/src/category`);
                this.categories = res.data.data;
            } catch (error) {
                this.errors = error.response.data.message
            }
        },
        async fetchDocumentOnCategory() {
            try {
                const res = await axios.get(`/src/documents`, {params: {category_id: this.category}});
                this.documents = res.data.data;
            } catch (error) {
                this.errors = error.response.data.message
            }
        },
        async deleteDocument(document) {
            try {
                const res = await axios.post(`/src/document-delete`, {document_id: document.id});
                let successResponse = res.data.data;
                if(successResponse.success){
                    this.documents = this.documents.filter( doc => doc.id !== document.id)
                }
            } catch (error) {
                this.errors = error.response.data.message
            }
        },
    },
};