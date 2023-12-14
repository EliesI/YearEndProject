<template>
    <div class="modal" @click.self="$emit('close')">
        <div class="modal-content">
            <div class="flex justify-end">
                <button @click="$emit('close')">Fermer</button>
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;

    z-index: 9999;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content {
    width: 80%;
    max-width: 600px;
    max-height: 80%;

    background-color: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);

    transition: transform 0.3s ease-out;
    transform: scale(1);
}

.modal-content {
    transform: scale(0.8);
}
</style>