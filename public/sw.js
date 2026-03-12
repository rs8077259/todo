self.addEventListener('install',event=>{

})
self.addEventListener('push',event=>{ 
    const data =  event.data?.json()||{}
    const title = data?.title||"some error in push service";
    const message = data?.message||""
    const icon = '/favicon.ico'

    event.waitUntil(
        self.registration.showNotification(title,{
            body:message,
            icon,
        })
    )
})