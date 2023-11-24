# Users
- id
- name
- email
- password
- device_token
- user_type ['client', 'manager']
- avatar_url
- active

# Plans
- id
- name
- price
- active
- qtd_days [0]

# Clients
- id
- plan_id
- user_id
- phone
- due_date
- verified_at
- blocked_at

# Schedules
- id
- description
- professor
- weekday
- hours []
- limit
- active

# Events
- id
- schedule_id
- image_url
- price


# Checkins
- id
- user_id
- schedule_id
- type ['schedule*', 'event']
- checkin_date
- hour
- status ['scheduled', 'confirmed', 'canceled']