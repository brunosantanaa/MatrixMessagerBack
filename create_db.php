table user
- id
- name
- email
- password

table messager
- send_userid
- conversation_id
- content

table conversation
- id
- name
- group -> boolean

table conversationUsers
- conversation_id
- user_id