<script setup>
import { ref, onMounted } from 'vue'

const newTask = ref('')

const tasks = ref([])

async function fetchTasks() {

  try {

    const response = await fetch(
      'http://localhost:8000/api/tasks.php'
    )

    const data = await response.json()

    tasks.value = data

  } catch (error) {

    console.error('Error fetching tasks:', error)

  }

}

onMounted(() => {

  fetchTasks()

})

async function addTask() {

  if (!newTask.value.trim()) return

  try {

    const response = await fetch(
      'http://localhost:8000/api/create_task.php',
      {
        method: 'POST',

        headers: {
          'Content-Type': 'application/json'
        },

        body: JSON.stringify({
          title: newTask.value
        })
      }
    )

    const data = await response.json()

    if (data.success) {

      await fetchTasks()

      newTask.value = ''

    }

  } catch (error) {

    console.error('Error adding task:', error)

  }

}

async function deleteTask(id) {

  try {

    const response = await fetch(
      'http://localhost:8000/api/delete_task.php',
      {
        method: 'POST',

        headers: {
          'Content-Type': 'application/json'
        },

        body: JSON.stringify({
          id: id
        })
      }
    )

    const data = await response.json()

    if (data.success) {

      await fetchTasks()

    }

  } catch (error) {

    console.error('Error deleting task:', error)

  }

}

async function toggleTask(task) {

  task.completed = !task.completed

  try {

    await fetch(
      'http://localhost:8000/api/update_task.php',
      {
        method: 'POST',

        headers: {
          'Content-Type': 'application/json'
        },

        body: JSON.stringify({
          id: task.id,
          completed: task.completed
        })
      }
    )

  } catch (error) {

    console.error('Error updating task:', error)

  }

}
</script>

<template>
  <div class="app">

    <div class="task-container">

      <div class="header">
        <h1>BlueTask Dashboard</h1>
        <p>Stay organized and productive</p>
      </div>

      <div class="task-form">

        <input
          v-model="newTask"
          type="text"
          placeholder="Add a new task..."
          @keyup.enter="addTask"
        />

        <button @click="addTask">
          Add Task
        </button>

      </div>

      <div class="task-list">

        <div
          v-for="task in tasks"
          :key="task.id"
          class="task-card"
          :class="{ completed: task.completed }"
        >

          <div class="task-left">

            <label class="checkbox-container">

              <input
                type="checkbox"
                :checked="task.completed"
                @change="toggleTask(task)"
              >

              <span class="custom-checkbox"></span>

            </label>

            <span class="task-title">
              {{ task.title }}
            </span>

          </div>

          <button
            class="delete-btn"
            @click="deleteTask(task.id)"
          >
            Delete
          </button>

        </div>

      </div>

    </div>

  </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

html,
body,
#app {
  width: 100%;
  min-height: 100%;
  margin: 0;
  padding: 0;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background: linear-gradient(to bottom right, #eef4ff, #dbeafe);
  font-family: 'Montserrat', sans-serif;
  color: #1e293b;
  overflow-x: hidden;
}

.app {
  width: 100%;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  padding: 60px 20px;
}

.task-container {
  width: 100%;
  max-width: 700px;
  background: rgba(255, 255, 255, 0.72);
  backdrop-filter: blur(12px);
  border-radius: 28px;
  padding: 40px;
  box-shadow: 0 10px 40px rgba(59, 130, 246, 0.12);
}

.header {
  margin-bottom: 32px;
}

.header h1 {
  font-size: 42px;
  margin-bottom: 14px;
  color: #2563eb;
  font-weight: 600;
}

.header p {
  color: #64748b;
  font-size: 16px;
  font-weight: 500;
}

.task-form {
  display: flex;
  gap: 12px;
  margin-bottom: 22px;
}

.task-form input {
  flex: 1;
  padding: 15px;
  border-radius: 14px;
  border: 1px solid #bfdbfe;
  background: white;
  font-size: 15px;
  outline: none;
  font-family: 'Montserrat', sans-serif;
  font-weight: 500;
}

.task-form input:focus {
  border-color: #60a5fa;
}

.task-form button {
  border: none;
  background: #3b82f6;
  color: white;
  padding: 0 22px;
  border-radius: 14px;
  cursor: pointer;
  transition: 0.2s;
  font-size: 14px;
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
}

.task-form button:hover {
  background: #2563eb;
}

.task-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.task-card {
  background: white;
  border-radius: 16px;
  padding: 14px 18px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border: 1px solid #dbeafe;
}

.task-left {
  display: flex;
  align-items: center;
  gap: 14px;
}

.task-title {
  font-size: 15px;
  color: #1e293b;
  font-weight: 500;
}

.delete-btn {
  border: none;
  background: #eff6ff;
  color: #2563eb;
  padding: 10px 14px;
  border-radius: 12px;
  cursor: pointer;
  transition: 0.2s;
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
}

.delete-btn:hover {
  background: #dbeafe;
}

.checkbox-container {
  position: relative;
  width: 22px;
  height: 22px;
}

.checkbox-container input {
  opacity: 0;
  width: 0;
  height: 0;
}

.custom-checkbox {
  position: absolute;
  inset: 0;
  border-radius: 7px;
  border: 2px solid #93c5fd;
  background: white;
  transition: 0.2s;
}

.checkbox-container input:checked + .custom-checkbox::after {
  content: "✔";
  position: absolute;
  color: #2563eb;
  font-size: 15px;
  font-weight: 900;
  left: 3px;
  top: -2px;
}

.completed .task-title {
  text-decoration: line-through;
  opacity: 0.5;
}
.task-container {
  width: 100%;
  max-width: 700px;
  background: rgba(255, 255, 255, 0.78);
  backdrop-filter: blur(14px);
  border-radius: 28px;
  padding: 40px;

  box-shadow:
    0 22px 60px rgba(15, 23, 42, 0.08);

  animation: elegantAppear 2.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes elegantAppear {

  from {
    opacity: 0;
    transform: translateY(65px) scale(0.96);
    filter: blur(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0) scale(1);
    filter: blur(0);
  }

}
</style>