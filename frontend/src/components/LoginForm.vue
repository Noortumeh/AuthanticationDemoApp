<script setup>
    import { ref } from 'vue'
    const sendLoginData = async (email, password) => {
        const data = ref(null);
        const error = ref(null);

        const res = await fetch('http://127.0.0.1:8000/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });
        if (!res.ok) {
            error.value = 'Failed to login';
            console.error('Login failed');
            return;
        }
        data.value = await res.json();
        console.log('Login successful:', data.value);
    }
</script>

<template>
    <div>
        <h2>Login Form Component</h2>
        <!-- Login form implementation goes here -->
         <form @submit.prevent="sendLoginData($event.target.email.value, $event.target.password.value)">
            <div>
                <label style="margin-right: 2rem;" for="email">Email:</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
            </div>
            <button type="submit">Login</button>
         </form>
    </div>
</template>

<style scoped>
    form {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        max-width: 300px;
        margin: auto;
    }
    div {
        margin-bottom: 1rem;
    }
    label {
        margin-bottom: 0.5rem;
        font-weight: bold;
        margin-right: 4px;
    }
    input {
        padding: 0.5rem;
        font-size: 1rem;
    }
    button {
        padding: 0.5rem;
        font-size: 1rem;
        background-color: #42b983;
        color: white;
        border: none;
        cursor: pointer;
    }
    button:hover {
        background-color: #369870;
    }
</style>