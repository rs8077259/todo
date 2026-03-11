<x-layouts::app>
    <script>
        function getLocalTodo(parse = false) {
            if (parse)
                return JSON.stringify(localStorage.getItem('todo'))
            return localStorage.getItem('todo')
        }
        function sync() {
            //yet to implement

            body = getLocalTodo();
            fetch("/sync", {
                "body": body,
                method: "post",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json"
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

    <script>
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register('/sw.js').then(accepted => {
                //yet to implement
                console.log("accepted");

            }).catch(rej => {
                //yet to implement
                console.log('error');
            })


            navigator.serviceWorker.ready.then(reg => {

                reg.pushManager.getSubscription().then(
                    async (sub) => {
                        function urlBase64ToUint8Array(base64String) {
                            // Add padding if necessary
                            const padding = '='.repeat((4 - base64String.length % 4) % 4);
                            const base64 = (base64String + padding)
                                .replace(/-/g, '+') // Replace - with +
                                .replace(/_/g, '/'); // Replace _ with /

                            // Decode the base64 string
                            const rawData = window.atob(base64);
                            const outputArray = new Uint8Array(rawData.length);

                            // Convert to Uint8Array
                            for (let i = 0; i < rawData.length; ++i) {
                                outputArray[i] = rawData.charCodeAt(i);
                            }
                            return outputArray;
                        }
                        const response = await fetch('/webpush/publickey');
                        const data = await response.json();
                        const publicKey = data.publicKey;
                        


                        const applicationServerKey = urlBase64ToUint8Array(publicKey)

                        if (!sub) {
                            reg.pushManager.subscribe({
                                userVisibleOnly: true,
                                "applicationServerKey": applicationServerKey
                            }).then(
                                sub => {
                                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    fetch('/user/web/subscription', {
                                        method: "POST",
                                        headers: {
                                            'Content-Type': "application/json",
                                            'X-CSRF-TOKEN': csrf
                                        },
                                        body: JSON.stringify(sub)
                                    })
                                }
                            ).catch(error => {
                                console.log(error)
                            })
                        }
                        else {
                            /* navigator.serviceWorker.getRegistration().then(
                                reg => {
                                    reg.pushManager.subscribe({
                                        userVisibleOnly: true,
                                        "applicationServerKey": applicationServerKey
                                    }).then(
                                        sub => {
                                            console.log(sub)
                                            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            fetch('/user/web/subscription', {
                                                method: "POST",
                                                headers: {
                                                    'Content-Type': "application/json",
                                                    'X-CSRF-TOKEN': csrf
                                                },
                                                body: JSON.stringify(sub)
                                            })
                                        }
                                    ).catch(error => {
                                        console.log(error)
                                    })
                                }
                            ) */
                        }
                    }
                )
            })
        }


    </script>
</x-layouts::app>