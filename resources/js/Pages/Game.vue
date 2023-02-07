<template>
    <Head title="Dashboard"/>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex py-3">
                            <el-button @click="getHistory">History</el-button>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                Options
                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                          clip-rule="evenodd"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('regenerate',{uuid: uuid})" method="get" as="button">
                                            Regenerate link
                                        </DropdownLink>
                                        <DropdownLink :href="route('disable',{uuid: uuid} )" method="get" as="button">
                                            Disable link
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="py-12 flex">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 justify-center items-center">
                    <el-button type="success" @click="play">Im feeling lucky</el-button>
                </div>
            </div>
            <el-dialog
                v-model="resultDialog"
                title="Result"
                width="30%"
            >
                 <div v-if="result.type === 'win'" class="flex w-full justify-center items-center">
                    <p class="text-green-600"> Congratulations! You are winner! Your win - {{result.win}}</p>
                 </div>
                 <div v-else class="flex w-full justify-center items-center">
                     <span class="text-red-600">Oops! Sorry, but you lose!</span>
                 </div>
                <template #footer>
      <span class="dialog-footer">
        <el-button @click="resultDialog = false">Cancel</el-button>
      </span>
                </template>
            </el-dialog>

            <el-dialog v-model="historyDialog" title="Game history" width="20%">
                <el-table :data="history">
                    <el-table-column  property="date" label="Date" width="150" />
                    <el-table-column  property="result" label="Result" width="150" />
                    <el-table-column  property="win" label="Win" width="150" />
                </el-table>
            </el-dialog>
        </div>
    </div>
</template>
<script>
import {Head} from '@inertiajs/inertia-vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import {ElNotification} from 'element-plus'

export default {
    name: 'game',
    props: [
        'uuid'
    ],
    components: {
        Head,
        Dropdown,
        DropdownLink,
        ElNotification
    },
    data(){
        return {
            resultDialog: false,
            result: {
                type: '',
                win: '',
                number: ''
            },
            historyDialog: false,
            history: [
                {
                    date: '',
                    result: '',
                    win: ''
                }
            ]
        }
    },
    methods: {
        play: function () {
            axios.post(this.route('play', {uuid: this.uuid})).then(response => {
                this.result = response.data
                this.resultDialog = true
            })
        },
        getHistory: function(){
            axios.get(this.route('history', {uuid: this.uuid})).then(response => {
                this.history = response.data
                this.historyDialog = true
            })
        }

    }
}
</script>
