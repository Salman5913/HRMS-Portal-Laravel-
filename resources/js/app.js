import './bootstrap'
const msgForm = document.getElementById('messageForm')
const message_inp = document.getElementById('msg_inp')
const username_inp = document.getElementById('username_inp')
const ticket_id_inp = document.getElementById('ticket_id_inp')
const chat_container = document.getElementById('chat_container')
const login_user_id = document.getElementById('login_user_id')
//scroll to the latest chat
function scrollToBottom(){
chat_container.scrollTop = chat_container.scrollHeight;
}
scrollToBottom()
msgForm.addEventListener('submit', function (e) {
  e.preventDefault()
  let has_errors = false
  if (message_inp.value == '') {
    alert('Please enter message')
    has_errors = true
  }
  if (username_inp.value == '') {
    has_errors = true
  }
  if (has_errors) {
    return
  }
  const username = username_inp.value
  const message = message_inp.value
  var ticket_id = ticket_id_inp.value
  var login_id =login_user_id.value
  const options = {
    method: 'post',
    url: '/ticket-reply',
    data: {
      username: username,
      message: message,
      ticket_id: ticket_id,
      login_user_id: login_id
    }
  }
  // sending data to controller via axios request
  axios(options)
})
var login_id =login_user_id.value;
  var ticket_id = ticket_id_inp.value
  var channel = 'chat'+ticket_id;
//broadcast the new messages
window.Echo.channel(channel).listen('.ticketchat', (e) => {
   let align = '';
   let msg_details = '';
   let date =new Date();
   let hours = date.getHours();
   let minutes = date.getMinutes();
   let am_pm = hours>= 12 ? 'PM' : 'AM';//get  am pm
   hours = hours % 12 || 12 ; // 12 hours format
   minutes = minutes<10 ? '0'+minutes : minutes;
   // setting up the class for aligning the messages left or right and message details based on current user id
  if(e.login_user_id == login_id){
    align = 'align-items-end';
    msg_details = hours+':'+minutes+' '+am_pm;
  }else{
    align = 'align-items-start';
    msg_details = e.username+', '+hours+':'+minutes+' '+am_pm;
  }
  chat_container.innerHTML += `
  <div
  class="d-flex flex-column justify-content-around mt-2 mx-4 ${align} ">
  <div id="username_container" class=" text-muted">
      <span id="username">
      ${msg_details}
      </span>
  </div>
  <span id="msg_container" class="py-1 px-3 mt-1">${e.message}</span>
</div>
  `
message_inp.value = '';
scrollToBottom();
})
