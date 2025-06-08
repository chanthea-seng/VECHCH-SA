<template>
    <div class="col-6 m-auto position-relative">
        <div class="search-container d-flex align-items-center ">
            <!-- Dropdown -->
            <div class="dropdown">
                <button class="btn btn-dropdown dropdown-toggle  " type="button" id="search-dropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    ផ្នែកជំនាញ
                </button>
                <ul class="dropdown-menu" aria-labelledby="search-dropdown">
                    <li><a class="dropdown-item" href="#">ជំងឺស្នូលខ្នង</a></li>
                    <li><a class="dropdown-item" href="#">ជំងឺទ្រូង</a></li>
                    <li><a class="dropdown-item" href="#">ជំងឺឆ្អឹង</a></li>
                    <li><a class="dropdown-item" href="#">ជំងឺទឹកនោមផ្អែម</a></li>
                    <li><a class="dropdown-item" href="#">ជំងឺការលំបាកសើស្បែក</a></li>
                </ul>
            </div>

            <input type="text" class="form-control bg-transparent" placeholder="ស្វែងរកឈ្មោះវេជ្ជបណ្ឌិត"
                aria-label="Search" @focus="showSearchHistory = true" @blur="hideSearchHistory" />
            <span class="search-icon position-absolute">
                <i class="fa-regular fa-magnifying-glass"></i>
            </span>
        </div>

        <div class="card position-absolute z-3 " v-if="showSearchHistory">
            <div class="card-body  ">
                <div class="d-flex justify-content-between">
                    <h5>ការស្វែងរកថ្មីៗ</h5>
                    <a role="button" class="text-color-800 text-decoration-none">
                        លុបទាំងអស់
                    </a>
                </div>
                <div class="d-flex flex-wrap gap-3 ">
                    <div class="card-search p-2 me-2 border rounded-3 " v-for="searchdata in historysearch.searchHistory" 
                        :key="searchdata.id">
                        <span>{{ searchdata.name }}</span>
                        <a href="#" role="button" class="text-color-700 fs-6 ms-4 me-1" @click="removedSearch()">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { historySearch } from '@/stores/finddcotorstore';

const historysearch = historySearch();
const showSearchHistory = ref(false);

const hideSearchHistory = () => {
    showSearchHistory.value = false;
};

</script>
