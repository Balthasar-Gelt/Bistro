<template>
        
    <div :class="notificationClass" class="notification-wrapper">
        <h1>{{notificationMessage}}</h1>
    </div>

</template>

<script>

export default {
    props: {
        notificationMessage: '',
        notificationClass: '',
    },
}
</script>

<style lang="scss" scoped>

@import '../../scss/_variables';

.notification-wrapper{
    position: fixed;
    top: 25%;
    left: 50%;
    transform: translateX(-50%);
    border: 2px solid black;
    background-color: white;
    width: 20%;
    padding: 1em 1em;
    z-index: 100;
}

.error{
    background-color: $errorColor;
    color: white;
}

.success{
    background-color: $successColor;
    color: black;
}

h1{
    font-family: $ff;
    font-size: 1.2em;
    margin: 0;
}

</style>