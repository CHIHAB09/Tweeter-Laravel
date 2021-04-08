    <template>
            <div class="py-6">
                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                    <form @submit.prevent="tweetStore">
                        <textarea v-model="content" placeholder="Que se passe-t-il ?" class="rounded-lg border
                        border-gray-200 w-full p-2 font-semibold resize-none focus:outline-none"></textarea>
                        <span class="my-5 text-red-500">


                        </span>
                        <div class="flex items-center space-x-4 justify-end mt-3">
                            <p :class="{'text-red-500': remainingChars < 0}" class="text-sm text-gray-400 font-thin">{{ remainingChars }} caractères restants</p>
                            <!--On dit au boutton d etre invisible grace a canSubmit permet de verifier si raimaingChars est egal ou sup a 0 ou alors this content est present -->
                            <button-vue :disabled="!canSubmit" class="bg-blue-500 hover:bg-blue-800 
                            rounded-full font-extrabold">Tweet</button-vue>
                        </div>
                    </form>
                </div>
            </div>
    </template>

<script>

    import ButtonVue from '@/Jetstream/Button'

    export default {

    components: {
        ButtonVue

        },

    data(){
        return {
            content:'',
            limit:280
        }
    },
    
    methods: {
        tweetStore(){
            this.$inertia.post('tweets', {content: this.content}, {preserveState: false})
            }
        },
    computed: {
        remainingChars(){
            return this.limit - this.content.length
        },
        canSubmit(){
            return this.content.length && this.remainingChars >= 0;
        }
    }

    }
    
</script>

<style scoped>
    button:disabled {
        opacity: 50%;
        cursor: not-allowed;
    }
</style>