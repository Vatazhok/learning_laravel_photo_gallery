<template>
    <div class="modal-backdrop">
        <div class="modal">
            <header class="modal-header">
                <slot name="header">
                    This is the default title!
                </slot>
                <button
                    type="button"
                    class="btn-close text-yellow-600"
                    @click="close"
                >
                    x
                </button>
            </header>

            <section class="modal-body">
                <slot name="body">
                    This is the default body!
                </slot>
            </section>

            <footer class="modal-footer flex-wrap justify-between">
                <slot name="footer">
                    This is the default footer!
                </slot>
                <button
                    type="button"
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 border border-yellow-700 rounded"
                    @click="close"
                >
                    Close
                </button>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Modal',
    methods: {
        close() {
            this.$emit('close');
        },
    },
};
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
}

.modal-header,
.modal-footer {
    padding: 15px;
    display: flex;
}

.modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    /*color: #4AAE9B;*/
    justify-content: space-between;
}

.modal-footer {
    /*border-top: 1px solid #eeeeee;*/
    /*flex-direction: column;*/
    /*justify-content: flex-end;*/
}

.modal-body {
    /*position: relative;*/
    padding: 20px 10px;
}

.btn-close {
    position: absolute;
    top: 0;
    right: 5px;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    /*color: #4AAE9B;*/
    background: transparent;
}

/*.btn-green {*/
/*    color: white;*/
/*    !*background: #4AAE9B;*!*/
/*    border: 1px solid #4AAE9B;*/
/*    border-radius: 2px;*/
/*}*/
</style>
