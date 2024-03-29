@extends('layouts.main')

@section('content')
  <div class="container px-6 mx-auto grid" x-data="serverApp()" id="server-creation-container">
    <div class="mb-4 flex justify-between py-6">

      <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">
        {{ __('Create Server') }}
      </h2>
    </div>

    <!-- FORM -->
    <form action="{{ route('servers.store') }}" method="POST" class="" x-on:submit="submitClicked = true">
      @csrf
      @method('POST')
      <div class="px-4 py-3 pb-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div class="card">

          <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
            {{ __('Server Configuration') }}

            @if (!config('SETTINGS::SYSTEM:CREATION_OF_NEW_SERVERS'))
              <x-alert title="The creation of new servers has been disabled for regular users" type="danger">
              </x-alert>
            @endif

            @if ($productCount === 0 || $nodeCount === 0 || count($nests) === 0 || count($eggs) === 0)
              <x-alert type="danger" title="Error!">
                <p class="">
                  @if (Auth::user()->role == 'admin')
                    {{ __('Make sure to link your products to nodes and eggs.') }} <br>
                    {{ __('There has to be at least 1 valid product for server creation') }}
                    <a href="{{ route('admin.overview.sync') }}"
                      class="m-2 text-purple-600 underline">{{ __('Sync now') }}</a>
                  @endif
                </p>
                <ul>
                  @if ($productCount === 0)
                    <li class="text-sm"> {{ __('No products available!') }}</li>
                  @endif

                  @if ($nodeCount === 0)
                    <li class="text-sm">{{ __('No nodes have been linked!') }}</li>
                  @endif

                  @if (count($nests) === 0)
                    <li class="text-sm">{{ __('No nests available!') }}</li>
                  @endif

                  @if (count($eggs) === 0)
                    <li class="text-sm">{{ __('No eggs have been linked!') }}</li>
                  @endif
                </ul>
              </x-alert>
            @endif


            <div x-cloak x-show="loading" class="overlay dark">
              <i class="fas fa-2x fa-sync-alt"></i>
            </div>

            <div class="card-body">
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="list-group pl-3">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">{{ __('Name') }}</span>
                <input x-model="name" id="name" name="name" type="text" required="required"
                  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  placeholder="Server Name">
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  {{ __('Software / Games') }}
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  required name="nest" id="nest" x-model="selectedNest" @change="setEggs();">
                  <option selected disabled hidden value="null">
                    {{ count($nests) > 0 ? __('Please select software ...') : __('---') }}</option>
                  @foreach ($nests as $nest)
                    <option value="{{ $nest->id }}">{{ $nest->name }}</option>
                  @endforeach
                </select>
              </label>

              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  {{ __('Specification') }}
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  id="egg" required name="egg" :disabled="eggs.length == 0" x-model="selectedEgg"
                  @change="fetchLocations();" required="required">
                  <option x-text="getEggInputText()" selected disabled hidden value="null">
                  </option>
                  <template x-for="egg in eggs" :key="egg.id">
                    <option x-text="egg.name" :value="egg.id"></option>
                  </template>
                </select>
              </label>
              <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                  {{ __('Node') }}
                </span>
                <select
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm border-gray-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  name="node" required id="node" x-model="selectedNode" :disabled="!fetchedLocations"
                  @change="fetchProducts();">
                  <option x-text="getNodeInputText()" disabled selected hidden value="null">
                  </option>

                  <template x-for="location in locations" :key="location.id">
                    <optgroup :label="location.name">

                      <template x-for="node in location.nodes" :key="node.id">
                        <option x-text="node.name" :value="node.id">

                        </option>
                      </template>
                    </optgroup>
                  </template>
                </select>
              </label>

            </div>
        </div>
      </div>

      <div x-cloak x-show="selectedNode != null">
        <input type="hidden" name="product" x-model="selectedProduct">
        <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 my-6">
          {{ __('Products') }}
        </h2>
        <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">


          <template x-for="product in products" :key="product.id">
            <div class="min-w-0 p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800">
              <h2 class="mb-4 font-semibold text-gray-600 dark:text-gray-300" x-text="product.name">
              </h2>
              <div class="w-full overflow-x-auto rounded-lg shadow-sm ">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                      <th class="px-4 py-3">{{ __('Resources') }}</th>
                      <th class="px-4 py-3">{{ __('Amount') }}</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <tr class="text-gray-700 dark:text-gray-400">
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <p class="font-semibold">
                            {{ __('CPU') }}
                          </p>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm" x-text="product.cpu + ' {{ __('vCores') }}'">
                      </td>
                    <tr>
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <p class="font-semibold">
                            {{ __('Memory') }}
                          </p>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm" x-text="product.memory + ' {{ __('MB') }}'">
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <p class="font-semibold">
                            {{ __('Disk') }}
                          </p>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm" x-text="product.disk + ' {{ __('MB') }}'">
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <p class="font-semibold">
                            {{ __('MySQL Databases') }}
                          </p>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm" x-text="product.databases">
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <p class="font-semibold">
                            {{ __('Allocations') }}
                          </p>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm" x-text="product.allocations">
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <p class="font-semibold">
                            {{ __('Description') }}
                          </p>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm" x-text="product.description">
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <p class="font-semibold">
                            {{ __('Required') }} {{ CREDITS_DISPLAY_NAME }}
                          </p>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm"
                        x-text="product.minimum_credits == -1 ? '{{ config('SETTINGS::USER:MINIMUM_REQUIRED_CREDITS_TO_MAKE_SERVER') }}' : product.minimum_credits">
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                          <p class="font-semibold">
                            {{ __('Price') }}
                            <span
                              class="font-normal dark:text-gray-400/75 text-gray-600">({{ CREDITS_DISPLAY_NAME }})</span>
                          </p>
                        </div>
                      </td>
                      <td class="px-4 py-3 text-sm">
                        <span x-text="product.price"></span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="mt-4 flex justify-evenly">
                <button type="submit" x-model="selectedProduct" name="product" :value="product.id"
                  :disabled="product.minimum_credits > user.credits || product.doesNotFit == true || submitClicked"
                  :class="product.minimum_credits > user.credits || product.doesNotFit == true || submitClicked ? 'disabled' :
                      ''"
                  @click="setProduct(product.id)"
                  x-text="product.doesNotFit == true ? '{{ __("Server can\'t fit on this node") }}' : (product.minimum_credits > user.credits ? '{{ __('Not enough') }} {{ CREDITS_DISPLAY_NAME }}!' : '{{ __('Create Server') }}')"
                  class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                </button>
              </div>
            </div>
          </template>
        </div>
      </div>
    </form>
  </div>

  <script>
    const getUrlParameter = (param) => {
      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      return urlParams.get(param);
    }

    document.addEventListener("DOMContentLoaded", function(event) {
      const alpine_data = document.querySelector('#server-creation-container')._x_dataStack[0];
      const software = getUrlParameter('software');
      const egg = getUrlParameter('specification');

      if (software) {
        document.querySelector('#nest').value = software;
        alpine_data.selectedNest = software;
        alpine_data.setEggs();
      }

      if (egg && alpine_data.eggs.length > 0) {
        document.querySelector('#egg').value = egg;
        alpine_data.selectedEgg = egg;

        alpine_data.fetchLocations();
      }
    });

    function serverApp() {
      return {
        //loading
        loading: false,
        fetchedLocations: false,
        fetchedProducts: false,

        //input fields
        name: null,
        selectedNest: null,
        selectedEgg: null,
        selectedNode: null,
        selectedProduct: null,

        //selected objects based on input
        selectedNestObject: {},
        selectedEggObject: {},
        selectedNodeObject: {},
        selectedProductObject: {},

        //values
        user: {!! $user !!},
        nests: {!! $nests !!},
        eggsSave: {!! $eggs !!}, //store back-end eggs
        eggs: [],
        locations: [],
        products: [],

        submitClicked: false,


        /**
         * @description set available eggs based on the selected nest
         * @note called whenever a nest is selected
         * @see selectedNest
         */
        async setEggs() {
          this.fetchedLocations = false;
          this.fetchedProducts = false;
          this.locations = [];
          this.products = [];
          this.selectedEgg = 'null';
          this.selectedNode = 'null';
          this.selectedProduct = 'null';

          this.eggs = this.eggsSave.filter(egg => egg.nest_id == this.selectedNest)

          //automatically select the first entry if there is only 1
          if (this.eggs.length === 1) {
            this.selectedEgg = this.eggs[0].id;
            await this.fetchLocations();
            return;
          }

          this.updateSelectedObjects()
        },

        setProduct(productId) {
          if (!productId) return

          this.selectedProduct = productId;
          this.updateSelectedObjects();

        },

        /**
         * @description fetch all available locations based on the selected egg
         * @note called whenever a server configuration is selected
         * @see selectedEg
         */
        async fetchLocations() {
          this.loading = true;
          this.fetchedLocations = false;
          this.fetchedProducts = false;
          this.locations = [];
          this.products = [];
          this.selectedNode = 'null';
          this.selectedProduct = 'null';

          let response = await fetch(`{{ route('products.locations.egg') }}/${this.selectedEgg}`).then(
              data => data.json())
            .catch(console.error)

          this.fetchedLocations = true;
          this.locations = response

          //automatically select the first entry if there is only 1
          if (this.locations.length === 1 && this.locations[0]?.nodes?.length === 1) {
            this.selectedNode = this.locations[0]?.nodes[0]?.id;
            await this.fetchProducts();
            return;
          }

          this.loading = false;
          this.updateSelectedObjects()
        },

        /**
         * @description fetch all available products based on the selected node
         * @note called whenever a node is selected
         * @see selectedNode
         */
        async fetchProducts() {
          this.loading = true;
          this.fetchedProducts = false;
          this.products = [];
          this.selectedProduct = 'null';

          let response = await fetch(
              `{{ route('products.products.node') }}/${this.selectedEgg}/${this.selectedNode}`).then(
              data => data.json())
            .catch(console.error)

          this.fetchedProducts = true;
          // TODO: Sortable by user chosen property (cpu, ram, disk...)
          this.products = response.sort((p1, p2) => parseInt(p1.price, 10) > parseInt(p2.price, 10) &&
            1 || -1)

          //divide cpu by 100 for each product
          this.products.forEach(product => {
            product.cpu = product.cpu / 100;
          })


          this.loading = false;
          this.updateSelectedObjects()
        },

        /**
         * @description map selected id's to selected objects
         * @note being used in the server info box
         */
        updateSelectedObjects() {
          this.selectedNestObject = this.nests.find(nest => nest.id == this.selectedNest) ?? {}
          this.selectedEggObject = this.eggs.find(egg => egg.id == this.selectedEgg) ?? {}

          this.selectedNodeObject = {};
          this.locations.forEach(location => {
            if (!this.selectedNodeObject?.id) {
              this.selectedNodeObject = location.nodes.find(node => node.id == this.selectedNode) ?? {};
            }
          })

          this.selectedProductObject = this.products.find(product => product.id == this.selectedProduct) ?? {}
          console.log(this.selectedProduct, this.selectedProductObject, this.products)
        },

        /**
         * @description check if all options are selected
         * @return {boolean}
         */
        isFormValid() {
          if (Object.keys(this.selectedNestObject).length === 0) return false;
          if (Object.keys(this.selectedEggObject).length === 0) return false;
          if (Object.keys(this.selectedNodeObject).length === 0) return false;
          if (Object.keys(this.selectedProductObject).length === 0) return false;
          return !!this.name;
        },

        getNodeInputText() {
          if (this.fetchedLocations) {
            if (this.locations.length > 0) {
              return '{{ __('Please select a node ...') }}';
            }
            return '{{ __('No nodes found matching current configuration') }}'
          }
          return '{{ __('---') }}';
        },

        getProductInputText() {
          if (this.fetchedProducts) {
            if (this.products.length > 0) {
              return '{{ __('Please select a resource ...') }}';
            }
            return '{{ __('No resources found matching current configuration') }}'
          }
          return '{{ __('---') }}';
        },

        getEggInputText() {
          if (this.selectedNest) {
            return '{{ __('Please select a configuration ...') }}';
          }
          return '{{ __('---') }}';
        },

        getProductOptionText(product) {
          let text = product.name + ' (' + product.description + ')';

          if (product.minimum_credits > this.user.credits) {
            return '{{ __('Not enough credits!') }} | ' + text;
          }

          return text;
        }
      }
    }
  </script>
@endsection
