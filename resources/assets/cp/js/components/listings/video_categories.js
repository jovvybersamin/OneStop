
module.exports = {

	mixins:[Dossier],

	data:function(){
		return {
			ajax:{
				get:cp_url('videos/categories/get'),
				delete:cp_url('videos/categories/delete')
			},
			tableOptions:{
				hasHeader:true,
				sortCol:'name',
				sortOrder:'asc',
				partials:{
					actions:'',
					'cell':`
						<a v-if="$index === 0" href="{{ item.edit_url }}">
							<span class="">
								{{ item.name }}
							</span>
						</a>

						<span v-else>
							{{ item[column] }}
						</span>
					`
				}
			}
		};
	},


	ready:function(){
		this.addActionPartial();
	},


	methods:{
		addActionPartial:function(){
			var str = '';
			str += '<li><a href="{{ item.edit_url }}">Edit</a></li>';
			str += `<li class="warning">
						<a href="" @click.prevent="call('deleteItem',item.id)">Delete</a>
					</li>`;

			this.tableOptions.partials.actions = str;
		}

	}



}
