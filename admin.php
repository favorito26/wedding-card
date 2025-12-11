<?php
include 'db.php';
$res = $db->query("SELECT * FROM guests");

// Message
$baseMessage = "
Assalamu Alaikum {name},

You are cordially invited to the wedding ceremony.

Please visit the link below to view your personalized wedding invitation and submit your RSVP:
{invite_link}

Your presence will make the occasion more joyous.

Jazakallah Khair.
";
?>

<link rel="stylesheet" href="./css/output.css">

<div class="p-4 sm:p-6">

  <h1 class="text-xl sm:text-2xl font-bold mb-4">Admin Panel – Invitation List</h1>

  <div class="overflow-x-auto rounded-lg shadow bg-white border border-gray-200">

    <table class="min-w-full text-left border-collapse">
      <thead>
        <tr class="bg-amber-900 text-white text-sm sm:text-base">
          <th class="px-4 py-3 sm:px-6 sm:py-3 font-semibold">Name</th>
          <th class="px-4 py-3 sm:px-6 sm:py-3 font-semibold">Phone</th>
          <th class="px-4 py-3 sm:px-6 sm:py-3 font-semibold">RSVP</th>
          <th class="px-4 py-3 sm:px-6 sm:py-3 font-semibold">Action</th>
        </tr>
      </thead>

      <tbody class="divide-y divide-gray-200 text-sm sm:text-base">
        <?php while ($g = $res->fetch_assoc()): ?>
          <?php
            $inviteLink = "http://localhost:4000/index.php?id=" . $g['id'];
            $finalMessage = str_replace(["{name}", "{invite_link}"], [$g['name'], $inviteLink], $baseMessage);
            $encodedMsg = urlencode($finalMessage);
          ?>

          <tr class="hover:bg-gray-100 transition">
            <td class="px-4 py-4 sm:px-6"><?= $g['name'] ?></td>
            <td class="px-4 py-4 sm:px-6"><?= $g['phone'] ?></td>
            <td class="px-4 py-4 sm:px-6">
              <span class="
                px-3 py-1 rounded text-xs sm:text-sm
                <?php if($g['rsvp']=='accepted') echo 'bg-green-100 text-green-700'; ?>
                <?php if($g['rsvp']=='declined') echo 'bg-red-100 text-red-700'; ?>
                <?php if($g['rsvp']==null) echo 'bg-yellow-100 text-yellow-700'; ?>
              ">
                <?= $g['rsvp'] ?: 'Pending' ?>
              </span>
            </td>

            <td class="px-4 py-4 sm:px-6">
              <a
                href="https://wa.me/91<?= $g['phone'] ?>?text=<?= $encodedMsg ?>"
                target="_blank"
                class="inline-block bg-amber-700 hover:bg-amber-800 
                       text-white px-3 py-2 sm:px-4 sm:py-2 rounded shadow text-xs sm:text-sm">
                Send Message
              </a>
            </td>
          </tr>

        <?php endwhile; ?>
      </tbody>

    </table>
  </div>
</div>
