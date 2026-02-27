<x-layouts::app>
    <script>
        function getLocalTodo(parse = false) {
            if (parse)
                return JSON.stringify(localStorage.getItem('todo'))
            return localStorage.getItem('todo')
        }
        function sync() {
            console.log("sync runnign")

            body = getLocalTodo();
            fetch("/sync", {
                "body": body,
                method:"post",
                headers:{
                    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type" : "application/json"
                }
            })
        }
        function updateTodoComponent() {
            let component = document.getElementById("todoComponent");
            Alpine.$data(component).todo = JSON.parse(localStorage.getItem("todo")) || [];
        }
        function Completed(id = null) {
            let todo = JSON.parse(localStorage.getItem("todo"))
            let updatedTodo = todo.map(obj => {
                return obj.id === id ? { ...obj, completed: new Date() } : obj
            })
            localStorage.setItem('todo', JSON.stringify(updatedTodo))
            setTimeout(() => {
                updateTodoComponent()
            }, 300)

        }
    </script>
    <x-slot:title>workbook</x-slot:title>
    <x-Todo />
</x-layouts::app>