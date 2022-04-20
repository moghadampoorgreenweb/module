<!DOCTYPE html>
<html>
<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>

<h1>Export PDF</h1>

<table id="customers" dir="rtl">
    <tr>
        <th>Full Name</th>
        <th>email</th>
        <th>Title</th>
        <th>status user</th>
        <th>deparment name</th>
        <th>date</th>

    </tr>
    <tr>
        <?php

        collect($data)->each(function ($items){ ?>
    <tr>
        <td><?php echo $items->firstname . ' ' . $items->lastname ?></td>
        <td><?php echo $items->email ?></td>
        <td><?php echo $items->title ?></td>
        <td><?php echo $items->status_user ?></td>
        <td><?php echo $items->dpname ?></td>
        <td><?php echo \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', $items->date)
            ?>
        </td>
        <?php });

        ?>
</table>

</body>
</html>


