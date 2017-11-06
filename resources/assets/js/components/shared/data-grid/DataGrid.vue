<template>
	<div v-if="params.total !== 0">
        <table class="ui striped table">
            <thead>
                <tr>
                    <th v-for="item in thead" :class="item.style ? item.style : null" :colspan="item.columns ? item.columns : null">
                        <div v-if="item.sortable" @click="sort(item.column)" class="th-order">
                            {{ item.title }}
                            <span v-if="params.column === item.column">
                                <span v-if="params.direction === item.direction">&#x25B2;</span>
                                <span v-else>&#x25BC;</span>
                            </span>
                        </div>
                        <div v-else>
                            {{ item.title }}
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <slot></slot>
            </tbody>
            <tfoot>
                <tr>
                    <th :colspan="colspan ? colspan : null">
                        <div class="ui grid">
                            <div class="three column row ui form">
                                <div class="column inline field">
                                    <label>Exibir</label>
                                    <select v-model="params.per_page" @change="fetchData">
                                        <option>15</option>
                                        <option>30</option>
                                        <option>45</option>
                                    </select>
                                    <label>registros</label>
                                </div>
                                <div class="column inline field">
                                    <div class="ui center aligned grid field">
                                        <label class="current_page">Página atual</label>
                                        <input type="text" class="two wide field" v-model="params.current_page" @keyup.enter="fetchData">
                                        <label class="current_page"> de {{ params.last_page }}</label>
                                    </div>
                                </div>
                                <div class="column inline field">
                                    <div class="ui right floated pagination menu">
                                        <a href="#" class="icon item" @click.prevent="prev">
                                            <i class="left chevron icon"></i>
                                        </a>
                                        <a href="#" class="icon item" @click.prevent="next">
                                            <i class="right chevron icon"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
	export default {
		props: {
			thead: {
				required: true,
				type: Array
			},
			colspan: {
				type: Number
			},
			params: {
				type: Object
			}
		},
		methods: {
            sort(column) {
                if(column === this.params.column) {
                    if(this.params.direction === 'desc') {
                        this.params.direction = 'asc'
                    } else {
                        this.params.direction = 'desc'
                    }
                } else {
                    this.params.column = column
                    this.params.direction = 'asc'
                }
                this.fetchData()
            },
            next() {
                if(this.params.next_page_url) {
                    this.params.current_page++
                    this.fetchData()
                }
            },
            prev() {
                if(this.params.prev_page_url) {
                    this.params.current_page--
                    this.fetchData()
                }
            },
            fetchData() {
            	this.$emit('loadData');
            }
        }
	}
</script>

<style scoped>
    .th-order {
        cursor: pointer;
    }
    .current_page {
        margin-top: 10px !important;
    }
</style>