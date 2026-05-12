# 🚀 Laravel Batch Processing System

A scalable and reusable batch processing system built using Laravel Sail (Docker), Redis Queues, and Laravel Horizon.

This project demonstrates asynchronous job processing, chunk-based batch execution, queue management, and large dataset handling using Laravel.

---

# 📌 Project Objective

Design and implement a scalable, generic batch processing system using:

- Laravel Sail (Docker)
- Redis Queues
- Laravel Horizon

The system generates bulk test data and processes records asynchronously in batches.

---

# ✨ Features

✅ Laravel Sail Docker Environment  
✅ Redis Queue Integration  
✅ Laravel Horizon Dashboard  
✅ Bulk Data Seeding (1000+ records)  
✅ Asynchronous Queue Processing  
✅ Chunk-based Batch Execution  
✅ Retry Handling  
✅ Queue Priority Support  
✅ Generic & Reusable Architecture  
✅ Scalable Background Job Processing  

---

# 🛠️ Technologies Used

| Technology | Purpose |
|------------|---------|
| Laravel 12 | Backend Framework |
| PHP | Server-side Language |
| MySQL | Database |
| Redis | Queue Driver |
| Laravel Horizon | Queue Monitoring |
| Docker | Containerization |
| Laravel Sail | Docker Environment |

---

# 📂 Project Structure

```bash
app/
 ├── Console/Commands/
 │    └── ProcessBatchCommand.php
 │
 ├── Jobs/
 │    └── ProcessBatchJob.php
 │
 ├── Models/
 │    └── TestRecord.php
 │
 └── Providers/
      └── HorizonServiceProvider.php

database/
 ├── migrations/
 └── seeders/

config/
 └── horizon.php
```
---

# ⚙️ Installation & Setup

## 1️⃣ Clone Repository

```bash
git clone https://github.com/bharatblde/laravel-batch-processing-system.git
cd laravel-batch-processing-system
```

---

## 2️⃣ Install Dependencies

```bash
composer install
```

---

## 3️⃣ Start Docker Containers

```bash
./vendor/bin/sail up -d
```

---

## 4️⃣ Configure Environment

Update `.env`

```env
QUEUE_CONNECTION=redis
REDIS_HOST=redis
```

---

## 5️⃣ Run Migrations

```bash
./vendor/bin/sail artisan migrate
```

---

## 6️⃣ Seed Bulk Test Data

```bash
./vendor/bin/sail artisan db:seed --class=BatchTestSeeder
```

This generates:
- 1000+ random records

---

## 7️⃣ Start Horizon

```bash
./vendor/bin/sail artisan horizon
```

---

## 8️⃣ Run Batch Processing Command

```bash
./vendor/bin/sail artisan app:process-batch-command
```

---

# 🔄 Batch Processing Workflow

### Step 1
Seeder generates 1000+ records.

### Step 2
Command fetches active records.

### Step 3
Records are processed in chunks of 25.

### Step 4
Jobs are dispatched asynchronously to Redis queue.

### Step 5
Horizon monitors queue lifecycle.

### Step 6
Status values are updated in bulk.

---

# 📦 Seeder Logic

```php
for ($i = 0; $i < 1000; $i++) {

    $data[] = [
        'name' => 'User_' . rand(1000, 9999),
        'status' => rand(1,10) <= 7 ? 1 : 0,
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

DB::table('test_records')->insert($data);
```

---

# ⚡ Batch Job Logic

```php
public $tries = 3;

public function handle()
{
    DB::table('test_records')
        ->whereIn('id', $this->ids)
        ->update(['status' => false]);
}
```

---

# 🔥 Chunk Processing

```php
Model::where('status', true)
    ->chunk(25, function ($records) {

        ProcessBatchJob::dispatch(
            $records->pluck('id')->toArray()
        )->onQueue('default');

    });
```

✔ Batch size strictly = 25

---

# 📊 Horizon Dashboard

Access Horizon Dashboard:

```text
http://localhost/horizon/dashboard
```

Horizon provides:
- Queue Monitoring
- Job Lifecycle Tracking
- Failed Jobs Monitoring
- Throughput Metrics
- Active Queue Status

---

# 🎯 Acceptance Criteria Completed

| Requirement | Status |
|-------------|--------|
| Laravel Sail Setup | ✅ |
| Redis Queue Driver | ✅ |
| Horizon Integration | ✅ |
| Bulk Data Seeding | ✅ |
| Async Job Processing | ✅ |
| Chunk Size = 25 | ✅ |
| Generic Reusable System | ✅ |
| Horizon Dashboard | ✅ |

---

# ⭐ Bonus Features Implemented

✅ Queue Priorities  
✅ Retry Handling  
✅ Scheduling Support  

---

# 🚀 Future Improvements

- Dynamic Queue Management
- Real-time Notifications
- Multi-queue Processing
- Queue Analytics Dashboard
- API-based Batch Triggers

---

# 👨‍💻 Author

## Bharat 

GitHub:
https://github.com/bharatblde

Project Repository:
https://github.com/bharatblde/laravel-batch-processing-system
