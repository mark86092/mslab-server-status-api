<?php
function print_in_terminal($data) {
	$now = new DateTime();
	$threshold = $now->sub(new DateInterval("PT20M"));

	printf("\x1b[32;1m%10s %8s %8s %8s %21s\x1b[39;22m\n", "Host", "Load1", "Load5", "Load15", "Memory(Used/Total)");
	foreach ($data as $d) {
		$a = DateTime::createFromFormat('Y-m-d H:i:s', $d['last_updated']);
		if ($threshold > $a ) {
			printf("\x1b[30;1m");
			printf("%10s ", $d['host']);
			foreach (array('load1', 'load5', 'load15') as $t) {
				printf("%8s ", $d[$t]);
			}
			printf("%10d ", $d['used_memory'] / 1024);
			printf("%10d ", $d['memory'] / 1024);
			printf("\x1b[0m");
		} else {
			printf("\x1b[1m%10s\x1b[0m ", $d['host']);
			foreach (array('load1', 'load5', 'load15') as $t) {
				if ($d[$t] > $d['cpu_cores']) {
					printf("\x1b[31;1m%8s\x1b[0m ", $d[$t]);
				} else {
					printf("%8s ", $d[$t]);
				}
			}
			printf("%10d ", $d['used_memory'] / 1024);
			printf("%10d ", $d['memory'] / 1024);
		}
		printf("\n");
	}
	printf("\nWebpage: http://mark86092.github.io/cluster-status/\n");
}
